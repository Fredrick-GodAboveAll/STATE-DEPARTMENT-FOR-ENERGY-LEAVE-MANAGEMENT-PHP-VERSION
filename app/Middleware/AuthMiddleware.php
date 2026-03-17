<?php
namespace App\Middleware;

use App\Core\Session;

class AuthMiddleware
{
    public function handle()
    {
        if (!Session::isLoggedIn()) {
            // Store the intended URL to redirect after login (optional)
            Session::flash('error', 'Please log in to access that page.');
            header('Location: /login');
            exit;
        }
    }
}