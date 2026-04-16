<?php
namespace App\Services;
use App\Models\User;
use App\Models\PasswordReset;
use App\Core\Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
class AuthService
{
 // AuthService contains the core user authentication and password reset behaviors.
 protected $userModel;
 protected $passwordResetModel;
 public function __construct()
 {
 $this->loadEnvFromDotEnvFile();
 $this->userModel = new User();
 $this->passwordResetModel = new PasswordReset();
 }
 public function attempt($email, $password)
 {
 // Verify the email/password combo and store the user in the session if valid.
 $user = $this->userModel->findByEmail($email);
 if (!$user || !password_verify($password, $user->password)) {
 return false;
 }
 session_regenerate_id(true);
 Session::set('user_id', $user->id);
 Session::set('user_name', $user->name);
 Session::set('user_role', $user->role);
 $this->userModel->updateLastLogin($user->id);
 return true;
 }
 public function register($data)
 {
 // Reject duplicate email addresses and store a hashed password.
 if ($this->userModel->findByEmail($data['email'])) return false;
 $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
 return $this->userModel->create($data);
 }
 public function logout()
 {
 // Remove all session data and end the user session.
 Session::destroy();
 }
 public function sendResetLink($email)
 {
 $user = $this->userModel->findByEmail($email);
 if (!$user) return false;

 $this->passwordResetModel->deleteByEmail($email);
 $token = bin2hex(random_bytes(32));

 if ($this->passwordResetModel->createToken($email, $token, null)) {
     if ($this->sendPasswordResetEmail($email, $token)) {
         return $token;
     }
 }
 return false;
 }

 protected function sendPasswordResetEmail($email, $token)
 {
     $appUrl = $this->getEnv('APP_URL', 'http://localhost:8000');
     $resetLink = rtrim($appUrl, '/') . '/reset-password?token=' . urlencode($token);
     $subject = 'Password Reset Request';
     $message = "Click the link below to reset your password:\r\n\r\n<{$resetLink}>";
     $headers = "From: noreply@yourdomain.com\r\n";
     $headers .= "Reply-To: noreply@yourdomain.com\r\n";
     $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

     // Prefer SMTP via PHPMailer when credentials are configured.
     $smtpHost = $this->getEnv('MAIL_HOST', null);
     $smtpPort = $this->getEnv('MAIL_PORT', 587);
     $smtpUser = $this->getEnv('MAIL_USERNAME', null);
     $smtpPass = $this->getEnv('MAIL_PASSWORD', null);
     $smtpSecure = $this->getEnv('MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_STARTTLS);

     if ($smtpHost && $smtpUser && $smtpPass) {
         try {
             $mail = new PHPMailer(true);
             $mail->isSMTP();
             $mail->Host = $smtpHost;
             $mail->SMTPAuth = true;
             $mail->Username = $smtpUser;
             $mail->Password = $smtpPass;
             $mail->SMTPSecure = $smtpSecure;
             $mail->Port = $smtpPort;
             $mail->setFrom($smtpUser, 'Leave Management');
             $mail->addAddress($email);
             $mail->isHTML(true);
             $mail->Subject = $subject;
             $mail->Body = "<p>Click the link below to reset your password:</p><p><a href=\"{$resetLink}\">{$resetLink}</a></p>";
             $mail->AltBody = "Click the link below to reset your password:\n\n<{$resetLink}>";
             $mail->send();
             return true;
         } catch (\Exception $e) {
             error_log('Password reset email error: ' . $mail->ErrorInfo);
             return false;
         }
     }

     // Fallback to the default PHP mail() function if SMTP is not configured.
     return mail($email, $subject, $message, $headers);
 }
 public function validateResetToken($token)
 {
 return $this->passwordResetModel->findByToken($token);
 }
 public function resetPassword($token, $newPassword)
 {
 $record = $this->validateResetToken($token);
 if (!$record) return false;
 $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
 $this->userModel->updatePassword($record->email, $hashed);
 $this->passwordResetModel->deleteByEmail($record->email);
 return true;
 }

 private function getEnv(string $key, $default = null)
 {
 if (isset($_ENV[$key])) {
 return $_ENV[$key];
 }
 $value = getenv($key);
 if ($value !== false) {
 return $value;
 }
 return $default;
 }

 private function loadEnvFromDotEnvFile()
 {
 $envPath = dirname(__DIR__, 2) . '/.env';
 if (!file_exists($envPath)) {
 return;
 }
 $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
 foreach ($lines as $line) {
 $line = trim($line);
 if ($line === '' || $line[0] === '#') {
 continue;
 }
 if (strpos($line, '=') === false) {
 continue;
 }
 [$name, $value] = explode('=', $line, 2);
 $name = trim($name);
 $value = trim($value);
 $value = trim($value, '"');
 if (getenv($name) === false) {
 putenv("{$name}={$value}");
 $_ENV[$name] = $value;
 $_SERVER[$name] = $value;
 }
 }
 }
 public function check() { return Session::has('user_id'); }
 public function role() { return Session::get('user_role'); }
}
