<?php
// Root route - redirect to login
$router->get('/', 'AuthController@login');

// Authentication routes
// LOGIN
$router->get('/login', 'AuthController@login');
//SIGNUP
$router->get('/register', 'AuthController@register');
// FORGOT PASSWORD 
$router->get('/forgot-password', 'AuthController@forgotPassword');
// RESET PASSWORD
$router->get('/reset-password', 'AuthController@resetPassword');
// LOGOUT
$router->get('/logout', 'AuthController@logoutPage');
// CONFIRM-MAIL 
$router->get('/confirm-mail', 'AuthController@confirmMail');
// LOCK-SCREEN 
$router->get('/lock-screen', 'AuthController@lockScreen');

// admin-dashboard routes
// DASHBOARD 
$router->get('/dashboard', 'DashboardController@dashboard');