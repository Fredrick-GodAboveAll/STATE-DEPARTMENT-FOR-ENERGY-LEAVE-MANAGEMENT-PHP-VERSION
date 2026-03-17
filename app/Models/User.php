<?php
namespace App\Controllers;

class AuthController extends Controller
{
    public function login()
    {
        // Set the content to be injected into the layout
        $content = '../app/Views/auth/login.php';
        
        // Include the layout (which will include the content)
        include '../app/Views/layouts/auth.php';
    }
}