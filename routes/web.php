<?php
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\RoleMiddleware;
// Guest routes
$router->get('/', 'AuthController@login', [GuestMiddleware::class]);
$router->get('/login', 'AuthController@login', [GuestMiddleware::class]);
$router->post('/login', 'AuthController@doLogin', [GuestMiddleware::class]);
$router->get('/register', 'AuthController@register', [GuestMiddleware::class]);
$router->post('/register', 'AuthController@doRegister', [GuestMiddleware::class]);
$router->get('/forgot-password', 'AuthController@forgotPassword', [GuestMiddleware::class]);
$router->post('/forgot-password', 'AuthController@doForgotPassword', [GuestMiddleware::class]);
$router->get('/reset-password', 'AuthController@resetPassword', [GuestMiddleware::class]);
$router->post('/reset-password', 'AuthController@doResetPassword', [GuestMiddleware::class]);
$router->get('/confirm-mail', 'AuthController@confirmMail', [GuestMiddleware::class]);
$router->get('/verify-email', 'AuthController@verifyEmail', [GuestMiddleware::class]);
$router->get('/offline', 'AuthController@offline');
// Protected routes
$router->get('/logout', 'AuthController@logout');
$router->post('/logout', 'AuthController@logout');
$router->get('/lock-screen', 'AuthController@lockScreen', [AuthMiddleware::class]);
$router->post('/unlock', 'AuthController@doUnlock', [AuthMiddleware::class]);
$router->get('/dashboard', 'DashboardController@index', [AuthMiddleware::class]);
// Admin-only route example
$router->get('/admin/users', 'AdminController@index',
 [AuthMiddleware::class, [RoleMiddleware::class, 'admin']]);