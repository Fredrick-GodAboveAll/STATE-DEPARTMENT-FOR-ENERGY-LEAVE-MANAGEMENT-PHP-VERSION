<?php
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\RoleMiddleware;

// Route Structure Rules
// GET routes for displaying pages
// POST routes for form submissions
// Always include `[AuthMiddleware::class]` for protected routes
// Use consistent URL patterns

// Guest routes ----- AUTHENTICATION 
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

// Dashboard Routes 
$router->get('/dashboard', 'DashboardController@index', [AuthMiddleware::class]);
$router->get('/analyticcs', 'DashboardController@analytics', [AuthMiddleware::class]);

// Applications Routes 
$router->get('/calender', 'ApplicationsController@index', [AuthMiddleware::class]);

// Leave Management Routes 
$router->get('/leave_management', 'LeaveController@index', [AuthMiddleware::class]);

$router->get('/leave-records', 'LeaveController@leave_records', [AuthMiddleware::class]);
$router->get('/leave-types', 'LeaveController@leave_types', [AuthMiddleware::class]);
$router->get('/leave-reports', 'LeaveController@leave_reports', [AuthMiddleware::class]);
$router->get('/leave-policies', 'LeaveController@leave_policies', [AuthMiddleware::class]);

// Holiday Route 
$router->get('/holidays', 'HolidaysController@index', [AuthMiddleware::class]);


// Other Routes 
// Future HR routes (pages will be added later)
$router->get('/employees', 'EmployeeController@index', [AuthMiddleware::class]);

$router->get('/employees/detail', 'EmployeeController@detail', [AuthMiddleware::class]);
$router->get('/employees/departments', 'EmployeeController@departments', [AuthMiddleware::class]);
$router->get('/employees/upload', 'EmployeeController@upload', [AuthMiddleware::class]);
$router->post('/employees/import', 'EmployeeController@import', [AuthMiddleware::class]);
$router->get('/departments', 'DepartmentController@index', [AuthMiddleware::class]);
$router->get('/reports', 'ReportsController@index', [AuthMiddleware::class]);

// Admin-only route example
$router->get('/admin/users', 'AdminController@index',
 [AuthMiddleware::class, [RoleMiddleware::class, 'admin']]);