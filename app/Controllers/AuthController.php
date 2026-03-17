<?php
namespace App\Controllers;

class AuthController extends Controller
{
    public function login()
    {
        $title = 'Login';
        $content = '../app/Views/auth/login.php';
        include '../app/Views/layouts/auth.php';
    }

    public function register()
    {
        $title = 'Register';
        $content = '../app/Views/auth/register.php';
        include '../app/Views/layouts/auth.php';
    }

    public function forgotPassword()
    {
        $title = 'Forgot Password';
        $content = '../app/Views/auth/forgot-password.php';
        include '../app/Views/layouts/auth.php';
    }

    public function resetPassword()
    {
        $title = 'Reset Password';
        $content = '../app/Views/auth/reset-password.php';
        include '../app/Views/layouts/auth.php';
    }

    public function logoutPage()
    {
        $title = 'Logged Out';
        $content = '../app/Views/auth/logout.php';
        include '../app/Views/layouts/auth.php';
    }

    public function confirmMail()
    {
        $title = 'Confirm Email';
        $content = '../app/Views/auth/confirm-mail.php';
        include '../app/Views/layouts/auth.php';
    }

    public function lockScreen()
    {
        $title = 'Lock Screen';
        $content = '../app/Views/auth/lock-screen.php';
        include '../app/Views/layouts/auth.php';
    }
}