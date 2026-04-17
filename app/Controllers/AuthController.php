<?php
namespace App\Controllers;
use App\Services\AuthService;
use App\Utils\Validator;
use App\Core\Csrf;
use App\Core\Session;
use App\Core\OfflineDetector;
use App\Models\User;
class AuthController extends Controller
{
 protected $authService;
 public function __construct()
 {
 // AuthService houses business logic for login, registration, logout, and password reset.
 $this->authService = new AuthService();
 }
 public function login()
 {
 $title = 'Login';
 $content = '../app/Views/auth/login.php';
 include '../app/Views/layouts/auth.php';
 }
 public function doLogin()
 {
 // Always verify the CSRF token before using any POST data.
 Csrf::validate($_POST['csrf_token'] ?? '');
 $validator = new Validator();
 $rules = ['email' => 'required|email', 'password' => 'required'];
 if (!$validator->validate($_POST, $rules)) {
 Session::flash('errors', $validator->errors());
 Session::flash('old', $_POST);
 header('Location: /login'); exit;
 }
 $result = $this->authService->attempt($_POST['email'], $_POST['password']);
 
 if ($result === true) {
 header('Location: /dashboard'); exit;
 } elseif ($result === 'unverified_email') {
 Session::flash('error', 'Please verify your email address before logging in. Check your email for verification link.');
 header('Location: /login'); exit;
 } else {
 Session::flash('error', 'Invalid email or password. Your account may be locked after too many failed attempts.');
 header('Location: /login'); exit;
 }
 }
 public function register()
 {
 // Registration requires email verification, so check if system is online
 if (OfflineDetector::isOffline()) {
 Session::flash('offline_feature', 'Registration');
 header('Location: /offline'); exit;
 }
 $title = 'Register';
 $content = '../app/Views/auth/register.php';
 include '../app/Views/layouts/auth.php';
 }
 public function doRegister()
 {
 // Check if system is offline before allowing registration
 if (OfflineDetector::isOffline()) {
 Session::flash('error', 'Registration is not available offline. Please connect to the internet.');
 header('Location: /register'); exit;
 }
 // Ensure the registration request is secure before validation.
 Csrf::validate($_POST['csrf_token'] ?? '');
 $validator = new Validator();
 $rules = [
 'name' => 'required',
 'email' => 'required|email',
 'password' => 'required|min:8|confirmed',
 'password_confirm' => 'required'
 ];
 if (!$validator->validate($_POST, $rules)) {
 Session::flash('errors', $validator->errors());
 Session::flash('old', $_POST);
 header('Location: /register'); exit;
 }
 $data = ['name' => $_POST['name'], 'email' => $_POST['email'],
 'password' => $_POST['password']];
 if ($this->authService->register($data)) {
 Session::flash('success', 'Registration successful. Please check your email to verify your account.');
 header('Location: /login'); exit;
 } else {
 Session::flash('error', 'Email already exists.');
 header('Location: /register'); exit;
 }
 }
 public function forgotPassword()
 {
 // Password reset requires email capability, so check if system is online
 if (OfflineDetector::isOffline()) {
 Session::flash('offline_feature', 'Password Reset');
 header('Location: /offline'); exit;
 }
 $title = 'Forgot Password';
 $content = '../app/Views/auth/forgot-password.php';
 include '../app/Views/layouts/auth.php';
 }
 public function doForgotPassword()
 {
 // Check if system is offline before allowing password reset
 if (OfflineDetector::isOffline()) {
 Session::flash('error', 'Password reset is not available offline. Please connect to the internet.');
 header('Location: /forgot-password'); exit;
 }
 // Protect the forgot-password form from CSRF attacks.
 Csrf::validate($_POST['csrf_token'] ?? '');
 $validator = new Validator();
 if (!$validator->validate($_POST, ['email' => 'required|email'])) {
 Session::flash('errors', $validator->errors());
 header('Location: /forgot-password'); exit;
 }
 $token = $this->authService->sendResetLink($_POST['email']);
 if ($token) {
 Session::flash('reset_email', $_POST['email']);
 header('Location: /confirm-mail'); exit;
 } else {
 Session::flash('error', 'Unable to send reset email. Please try again.');
 header('Location: /forgot-password'); exit;
 }
 }
 public function confirmMail()
 {
 $title = 'Check Your Email';
 $content = '../app/Views/auth/confirm-mail.php';
 include '../app/Views/layouts/auth.php';
 }
 public function resetPassword()
 {
 // Check if system is offline before showing reset form
 if (OfflineDetector::isOffline()) {
 Session::flash('offline_feature', 'Password Reset');
 header('Location: /offline'); exit;
 }
 // The reset link contains a token in the query string. We validate it before showing the form.
 $token = $_GET['token'] ?? '';
 if (!$token) { header('Location: /forgot-password'); exit; }
 if (!$this->authService->validateResetToken($token)) {
     Session::flash('error', 'Invalid or expired reset token.');
     header('Location: /forgot-password'); exit;
 }
 $title = 'Reset Password';
 $content = '../app/Views/auth/reset-password.php';
 include '../app/Views/layouts/auth.php';
 }
 
 public function doResetPassword()
 {
 // Check if system is offline before allowing password reset
 if (OfflineDetector::isOffline()) {
 Session::flash('error', 'Password reset is not available offline. Please connect to the internet.');
 header('Location: /forgot-password'); exit;
 }
 Csrf::validate($_POST['csrf_token'] ?? '');
 $token = $_POST['token'] ?? '';
 if (!$token) {
     Session::flash('error', 'Invalid request. Missing reset token.');
     header('Location: /forgot-password'); exit;
 }
 
 $validator = new Validator();
 if (!$validator->validate($_POST, [
     'password' => 'required|min:8|confirmed',
     'password_confirm' => 'required'
 ])) {
     Session::flash('errors', $validator->errors());
     header('Location: /reset-password?token=' . urlencode($token)); exit;
 }
 
 $password = $_POST['password'];
 if ($this->authService->resetPassword($token, $password)) {
     Session::flash('success', 'Password reset successful. Please login with your new password.');
     header('Location: /login'); exit;
 } else {
     Session::flash('error', 'Invalid or expired reset token. Please request a new password reset.');
     header('Location: /forgot-password'); exit;
 }
 }
 public function logout()
 {
 $this->authService->logout();
 $this->logoutPage();
 }
 public function logoutPage()
 {
 $title = 'Logged Out';
 $content = '../app/Views/auth/logout.php';
 include '../app/Views/layouts/auth.php';
 }
 public function lockScreen()
 {
 if (!$this->authService->check()) { header('Location: /login'); exit; }
 $title = 'Lock Screen';
 $content = '../app/Views/auth/lock-screen.php';
 include '../app/Views/layouts/auth.php';
 }
 
 public function verifyEmail()
 {
 // Check if system is offline before allowing email verification
 if (OfflineDetector::isOffline()) {
 Session::flash('error', 'Email verification is not available offline. Please connect to the internet.');
 header('Location: /login'); exit;
 }
 $token = $_GET['token'] ?? '';
 if (!$token) {
 Session::flash('error', 'Invalid verification link.');
 header('Location: /login'); exit;
 }
 
 if ($this->authService->verifyEmail($token)) {
 Session::flash('success', 'Email verified successfully. You can now login.');
 header('Location: /login'); exit;
 } else {
 Session::flash('error', 'Invalid or expired verification token.');
 header('Location: /login'); exit;
 }
 }
 public function doUnlock()
 {
 Csrf::validate($_POST['csrf_token'] ?? '');
 $userId = Session::get('user_id');
 if (!$userId) { header('Location: /login'); exit; }
 $userModel = new User();
 $user = $userModel->find($userId);
 if ($user && password_verify($_POST['password'] ?? '', $user->password)) {
 header('Location: /dashboard'); exit;
 } else {
 Session::flash('error', 'Incorrect password.');
 header('Location: /lock-screen'); exit;
 }
 }

 public function offline()
 {
 $title = 'You Are Offline';
 $content = '../app/Views/auth/offline.php';
 include '../app/Views/layouts/auth.php';
 }
}
