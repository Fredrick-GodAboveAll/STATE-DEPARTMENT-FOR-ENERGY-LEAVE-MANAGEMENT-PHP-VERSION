# Complete Authentication System for Leave Management System

Hello! I'm excited to help you build a robust and secure authentication system for your Leave Management System. Based on the v3 blueprint, I've compiled everything you need into this friendly guide. I've made a few small improvements for clarity and kindness, like adding encouraging notes and smoother transitions. Let's get you set up with a solid foundation!

## 📦 Complete Authentication Module – File by File

### 1. Folder Structure (Create these folders)
```
project-root/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Services/
│   ├── Middleware/
│   ├── Core/
│   ├── Utils/
│   └── Views/
│       ├── layouts/
│       │   └── partials/
│       ├── auth/
│       ├── dashboard/
│       └── errors/
├── config/
├── routes/
├── public/
│   ├── assets/          (Falcon template assets – place here)
│   └── vendors/         (Falcon template vendors – place here)
├── storage/
│   ├── logs/
│   └── uploads/
├── vendor/               (will be created by Composer)
├── .env
├── .env.example
├── composer.json
├── .gitignore
└── README.md
```

---

### 2. Database Schema
Run this SQL in your MySQL database. It's straightforward and sets up everything you need for users and password resets.
```sql
CREATE DATABASE IF NOT EXISTS `leave_management`
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `leave_management`;

-- Users table
CREATE TABLE `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin','user') NOT NULL DEFAULT 'user',
    `last_login` TIMESTAMP NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Password resets table
CREATE TABLE `password_resets` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(100) NOT NULL,
    `token` VARCHAR(64) NOT NULL,
    `expires_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_email` (`email`),
    INDEX `idx_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default users (password = 'password')
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Admin User', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Regular User', 'user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');
```

---

### 3. Root Files

#### **composer.json**
```json
{
    "name": "yourname/leave-management",
    "description": "Leave Management System - Authentication Module",
    "type": "project",
    "license": "MIT",
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    },
    "require": {
        "phpmailer/phpmailer": "^6.8",
        "vlucas/phpdotenv": "^5.5"
    }
}
```

#### **.env.example**
```ini
APP_NAME="Leave Management System"
APP_ENV=local
APP_DEBUG=true

DB_HOST=localhost
DB_NAME=leave_management
DB_USER=root
DB_PASS=

MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

#### **.gitignore**
```
vendor/
.env
storage/logs/*
storage/uploads/*
```

#### **README.md**
```markdown
# Leave Management System – Authentication Module

## Setup
1. Run `composer install`
2. Copy `.env.example` to `.env` and set your database credentials
3. Import the SQL schema from the documentation
4. Place Falcon template assets in `public/assets/` and `public/vendors/`
5. Run `php -S localhost:8000 -t public`
6. Visit `http://localhost:8000` and log in with admin@example.com / password
```

---

### 4. Public Folder

#### **public/index.php**
```php
<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Session;
use App\Core\ErrorHandler;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Start session
Session::start();

// Set error handling
$errorHandler = new ErrorHandler();
$errorHandler->register();

$router = new Router();

// Load routes
require __DIR__ . '/../routes/web.php';

// Dispatch
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($uri, $method);
```

#### **public/.htaccess**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [QSA,L]
</IfModule>
```

---

### 5. Config Files

#### **config/app.php**
```php
<?php
return [
    'name' => $_ENV['APP_NAME'] ?? 'Leave Management',
    'env' => $_ENV['APP_ENV'] ?? 'local',
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? true, FILTER_VALIDATE_BOOLEAN),
];
```

#### **config/database.php**
```php
<?php
return [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'name' => $_ENV['DB_NAME'] ?? 'leave_management',
    'user' => $_ENV['DB_USER'] ?? 'root',
    'pass' => $_ENV['DB_PASS'] ?? '',
];
```

#### **config/constants.php**
```php
<?php
define('BASE_PATH', dirname(__DIR__));
define('STORAGE_PATH', BASE_PATH . '/storage');
```

---

### 6. Core Classes

#### **app/Core/Database.php**
```php
<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        try {
            $this->pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['name']};charset=utf8mb4",
                $config['user'],
                $config['pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                ]
            );
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}
```

#### **app/Core/Session.php**
```php
<?php
namespace App\Core;

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function flash($key, $value = null)
    {
        if ($value !== null) {
            $_SESSION['flash'][$key] = $value;
        } else {
            $val = $_SESSION['flash'][$key] ?? null;
            unset($_SESSION['flash'][$key]);
            return $val;
        }
    }
}
```

#### **app/Core/Csrf.php**
```php
<?php
namespace App\Core;

class Csrf
{
    public static function generate()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validate($token)
    {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            die('Invalid CSRF token');
        }
        // Optional: unset for one-time use
        unset($_SESSION['csrf_token']);
        return true;
    }
}
```

#### **app/Core/ErrorHandler.php**
```php
<?php
namespace App\Core;

class ErrorHandler
{
    public function register()
    {
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
    }

    public function handleError($level, $message, $file, $line)
    {
        if (error_reporting() & $level) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    public function handleException($exception)
    {
        // Log error
        $log = date('Y-m-d H:i:s') . ' - ' . $exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine() . PHP_EOL;
        file_put_contents(STORAGE_PATH . '/logs/error.log', $log, FILE_APPEND);

        // Display friendly page
        $config = require __DIR__ . '/../../config/app.php';
        if ($config['debug']) {
            echo "<h1>Exception</h1>";
            echo "<p>" . $exception->getMessage() . "</p>";
            echo "<pre>" . $exception->getTraceAsString() . "</pre>";
        } else {
            http_response_code(500);
            include __DIR__ . '/../Views/errors/500.php';
        }
        exit;
    }
}
```

#### **app/Core/Router.php**
```php
<?php
namespace App\Core;

class Router
{
    protected $routes = [];

    public function get($uri, $action, $middleware = [])
    {
        $this->addRoute('GET', $uri, $action, $middleware);
    }

    public function post($uri, $action, $middleware = [])
    {
        $this->addRoute('POST', $uri, $action, $middleware);
    }

    protected function addRoute($method, $uri, $action, $middleware)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public function dispatch($uri, $method)
    {
        $uri = strtok($uri, '?');
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['uri'] === $uri) {
                // Run middleware
                foreach ($route['middleware'] as $mw) {
                    if (is_string($mw)) {
                        $middleware = new $mw();
                        $middleware->handle();
                    } elseif (is_array($mw)) {
                        // e.g., ['role' => 'admin'] or ['RoleMiddleware', 'admin']
                        // For simplicity we'll handle just the case where first element is class and rest are args
                        $class = $mw[0];
                        $args = array_slice($mw, 1);
                        $reflector = new \ReflectionClass($class);
                        $middleware = $reflector->newInstanceArgs($args);
                        $middleware->handle();
                    }
                }
                // Call action
                return $this->callAction($route['action']);
            }
        }
        // No route matched
        http_response_code(404);
        include __DIR__ . '/../Views/errors/404.php';
        exit;
    }

    protected function callAction($action)
    {
        list($controller, $method) = explode('@', $action);
        $controller = "App\\Controllers\\{$controller}";
        $controllerInstance = new $controller();
        return $controllerInstance->$method();
    }
}
```

---

### 7. Middleware

#### **app/Middleware/AuthMiddleware.php**
```php
<?php
namespace App\Middleware;

use App\Core\Session;

class AuthMiddleware
{
    public function handle()
    {
        if (!Session::has('user_id')) {
            Session::flash('error', 'Please log in first.');
            header('Location: /login');
            exit;
        }
    }
}
```

#### **app/Middleware/GuestMiddleware.php**
```php
<?php
namespace App\Middleware;

use App\Core\Session;

class GuestMiddleware
{
    public function handle()
    {
        if (Session::has('user_id')) {
            header('Location: /dashboard');
            exit;
        }
    }
}
```

#### **app/Middleware/RoleMiddleware.php**
```php
<?php
namespace App\Middleware;

use App\Core\Session;

class RoleMiddleware
{
    protected $allowedRoles;

    public function __construct($roles)
    {
        $this->allowedRoles = is_array($roles) ? $roles : [$roles];
    }

    public function handle()
    {
        $userRole = Session::get('user_role');
        if (!$userRole || !in_array($userRole, $this->allowedRoles)) {
            http_response_code(403);
            die('Access denied. You do not have permission to view this page.');
        }
    }
}
```

---

### 8. Models

#### **app/Models/Model.php**
```php
<?php
namespace App\Models;

use App\Core\Database;
use PDO;

abstract class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
```

#### **app/Models/User.php**
```php
<?php
namespace App\Models;

use PDO;

class User extends Model
{
    protected $table = 'users';

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'] ?? 'user'
        ]);
    }

    public function updateLastLogin($id)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET last_login = NOW() WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updatePassword($email, $newPassword)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET password = ? WHERE email = ?");
        return $stmt->execute([$newPassword, $email]);
    }
}
```

#### **app/Models/PasswordReset.php**
```php
<?php
namespace App\Models;

use PDO;

class PasswordReset extends Model
{
    protected $table = 'password_resets';

    public function createToken($email, $token, $expires)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (email, token, expires_at) VALUES (?, ?, ?)");
        return $stmt->execute([$email, $token, $expires]);
    }

    public function findByToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE token = ? AND expires_at > NOW()");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function deleteByEmail($email)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE email = ?");
        return $stmt->execute([$email]);
    }
}
```

---

### 9. Services

#### **app/Services/AuthService.php**
```php
<?php
namespace App\Services;

use App\Models\User;
use App\Models\PasswordReset;
use App\Utils\Mailer;
use App\Core\Session;

class AuthService
{
    protected $userModel;
    protected $passwordResetModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->passwordResetModel = new PasswordReset();
    }

    public function attempt($email, $password)
    {
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
        if ($this->userModel->findByEmail($data['email'])) {
            return false;
        }
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->userModel->create($data);
    }

    public function logout()
    {
        Session::destroy();
    }

    public function sendResetLink($email)
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            return false;
        }

        $this->passwordResetModel->deleteByEmail($email);

        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->passwordResetModel->createToken($email, $token, $expires);

        // In a real app, send email. For now, log token.
        Mailer::send($email, 'Password Reset', "Click here to reset: /reset-password?token=$token");

        return $token;
    }

    public function validateResetToken($token)
    {
        return $this->passwordResetModel->findByToken($token);
    }

    public function resetPassword($token, $newPassword)
    {
        $record = $this->validateResetToken($token);
        if (!$record) {
            return false;
        }

        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->userModel->updatePassword($record->email, $hashed);
        $this->passwordResetModel->deleteByEmail($record->email);
        return true;
    }

    public function check()
    {
        return Session::has('user_id');
    }

    public function role()
    {
        return Session::get('user_role');
    }
}
```

---

### 10. Utils

#### **app/Utils/Validator.php**
```php
<?php
namespace App\Utils;

class Validator
{
    protected $errors = [];

    public function validate($data, $rules)
    {
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? '';
            $rulesArray = explode('|', $rule);
            foreach ($rulesArray as $singleRule) {
                $this->applyRule($field, $value, $singleRule, $data);
            }
        }
        return empty($this->errors);
    }

    protected function applyRule($field, $value, $rule, $data)
    {
        if ($rule === 'required' && empty($value)) {
            $this->errors[$field][] = ucfirst($field) . ' is required';
        }
        if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = ucfirst($field) . ' must be a valid email';
        }
        if (strpos($rule, 'min:') === 0) {
            $min = explode(':', $rule)[1];
            if (strlen($value) < $min) {
                $this->errors[$field][] = ucfirst($field) . " must be at least $min characters";
            }
        }
        if ($rule === 'confirmed') {
            $confirmField = $field . '_confirm';
            if (!isset($data[$confirmField]) || $value !== $data[$confirmField]) {
                $this->errors[$field][] = ucfirst($field) . ' confirmation does not match';
            }
        }
        // Add more rules as needed
    }

    public function errors()
    {
        return $this->errors;
    }
}
```

#### **app/Utils/Mailer.php** (dummy logger)
```php
<?php
namespace App\Utils;

class Mailer
{
    public static function send($to, $subject, $message)
    {
        $log = "To: $to\nSubject: $subject\nMessage: $message\n\n";
        file_put_contents(__DIR__ . '/../../storage/logs/email.log', $log, FILE_APPEND);
        return true;
    }
}
```

---

### 11. Controllers

#### **app/Controllers/Controller.php**
```php
<?php
namespace App\Controllers;

class Controller
{
    // Base controller (can add common methods later)
}
```

#### **app/Controllers/AuthController.php**
```php
<?php
namespace App\Controllers;

use App\Services\AuthService;
use App\Utils\Validator;
use App\Core\Csrf;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    protected $authService;

    public function __construct()
    {
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
        Csrf::validate($_POST['csrf_token'] ?? '');

        $validator = new Validator();
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        if (!$validator->validate($_POST, $rules)) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            header('Location: /login');
            exit;
        }

        if ($this->authService->attempt($_POST['email'], $_POST['password'])) {
            header('Location: /dashboard');
            exit;
        } else {
            Session::flash('error', 'Invalid email or password');
            header('Location: /login');
            exit;
        }
    }

    public function register()
    {
        $title = 'Register';
        $content = '../app/Views/auth/register.php';
        include '../app/Views/layouts/auth.php';
    }

    public function doRegister()
    {
        Csrf::validate($_POST['csrf_token'] ?? '');

        $validator = new Validator();
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirm' => 'required|confirmed'
        ];
        if (!$validator->validate($_POST, $rules)) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            header('Location: /register');
            exit;
        }

        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ];

        if ($this->authService->register($data)) {
            Session::flash('success', 'Registration successful. Please login.');
            header('Location: /login');
            exit;
        } else {
            Session::flash('error', 'Email already exists.');
            header('Location: /register');
            exit;
        }
    }

    public function forgotPassword()
    {
        $title = 'Forgot Password';
        $content = '../app/Views/auth/forgot-password.php';
        include '../app/Views/layouts/auth.php';
    }

    public function doForgotPassword()
    {
        Csrf::validate($_POST['csrf_token'] ?? '');

        $validator = new Validator();
        if (!$validator->validate($_POST, ['email' => 'required|email'])) {
            Session::flash('errors', $validator->errors());
            header('Location: /forgot-password');
            exit;
        }

        $token = $this->authService->sendResetLink($_POST['email']);
        if ($token) {
            Session::flash('reset_token', $token);
            Session::flash('reset_email', $_POST['email']);
            header('Location: /confirm-mail');
            exit;
        } else {
            Session::flash('success', 'If that email exists, a reset link has been sent.');
            header('Location: /forgot-password');
            exit;
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
        $token = $_GET['token'] ?? '';
        if (!$token) {
            header('Location: /forgot-password');
            exit;
        }

        if (!$this->authService->validateResetToken($token)) {
            Session::flash('error', 'Invalid or expired reset token.');
            header('Location: /forgot-password');
            exit;
        }

        $title = 'Reset Password';
        $content = '../app/Views/auth/reset-password.php';
        include '../app/Views/layouts/auth.php';
    }

    public function doResetPassword()
    {
        Csrf::validate($_POST['csrf_token'] ?? '');

        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if (!$token) {
            header('Location: /forgot-password');
            exit;
        }

        $validator = new Validator();
        if (!$validator->validate($_POST, [
            'password' => 'required|min:6',
            'password_confirm' => 'required|confirmed'
        ])) {
            Session::flash('errors', $validator->errors());
            header("Location: /reset-password?token=$token");
            exit;
        }

        if ($this->authService->resetPassword($token, $password)) {
            Session::flash('success', 'Password reset successful. Please login.');
            header('Location: /login');
            exit;
        } else {
            Session::flash('error', 'Invalid or expired reset token.');
            header('Location: /forgot-password');
            exit;
        }
    }

    public function logout()
    {
        $this->authService->logout();
        header('Location: /login');
        exit;
    }

    public function logoutPage()
    {
        $title = 'Logged Out';
        $content = '../app/Views/auth/logout.php';
        include '../app/Views/layouts/auth.php';
    }

    public function lockScreen()
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        }
        $title = 'Lock Screen';
        $content = '../app/Views/auth/lock-screen.php';
        include '../app/Views/layouts/auth.php';
    }

    public function doUnlock()
    {
        Csrf::validate($_POST['csrf_token'] ?? '');

        $password = $_POST['password'] ?? '';
        $userId = Session::get('user_id');
        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $userModel = new User();
        $user = $userModel->find($userId);
        if ($user && password_verify($password, $user->password)) {
            header('Location: /dashboard');
            exit;
        } else {
            Session::flash('error', 'Incorrect password.');
            header('Location: /lock-screen');
            exit;
        }
    }
}
```

#### **app/Controllers/DashboardController.php**
```php
<?php
namespace App\Controllers;

use App\Core\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $currentPage = 'dashboard';
        $content = '../app/Views/dashboard/index.php';
        include '../app/Views/layouts/admin.php';
    }
}
```

#### **app/Controllers/ErrorController.php**
```php
<?php
namespace App\Controllers;

class ErrorController extends Controller
{
    public function notFound()
    {
        http_response_code(404);
        $title = '404 - Page Not Found';
        $content = '../app/Views/errors/404.php';
        include '../app/Views/layouts/auth.php';
        exit;
    }

    public function serverError()
    {
        http_response_code(500);
        $title = '500 - Server Error';
        $content = '../app/Views/errors/500.php';
        include '../app/Views/layouts/auth.php';
        exit;
    }
}
```

---

### 12. Views

#### **Layouts**

##### **app/Views/layouts/auth.php**
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Leave Management' ?></title>
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="/assets/img/favicons/manifest.json">
    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link href="/assets/css/theme.min.css" rel="stylesheet">
    <link href="/assets/css/user.min.css" rel="stylesheet">
</head>
<body>
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <?php include __DIR__ . '/partials/_offcanvas.php'; ?>
            <?= $content ?? '' ?>
        </div>
    </main>

    <script src="/vendors/popper/popper.min.js"></script>
    <script src="/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="/vendors/fontawesome/all.min.js"></script>
    <script src="/assets/js/theme.js"></script>
</body>
</html>
```

##### **app/Views/layouts/admin.php**
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Admin Dashboard' ?></title>
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="/assets/img/favicons/manifest.json">
    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link href="/assets/css/theme.min.css" rel="stylesheet">
    <link href="/assets/css/user.min.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/partials/_navbar.php'; ?>

    <main class="container mt-4">
        <?php include $content; ?>
    </main>

    <?php include __DIR__ . '/partials/_offcanvas.php'; ?>

    <script src="/vendors/popper/popper.min.js"></script>
    <script src="/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="/vendors/fontawesome/all.min.js"></script>
    <script src="/assets/js/theme.js"></script>
</body>
</html>
```

#### **Partials**

##### **app/Views/layouts/partials/_navbar.php**
```php
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/dashboard">Leave Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage == 'dashboard') ? 'active' : '' ?>" href="/dashboard">Dashboard</a>
                </li>
                <?php if (\App\Core\Session::get('user_role') === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/users">Manage Users</a>
                </li>
                <?php endif; ?>
                <!-- Add more menu items as needed -->
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <?= \App\Core\Session::get('user_name') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/profile">Profile</a></li>
                        <li><a class="dropdown-item" href="/lock-screen">Lock Screen</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="/logout">
                                <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::generate(); ?>">
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
```

##### **app/Views/layouts/partials/_offcanvas.php**
```php
<!-- Offcanvas Settings Panel (Falcon template) – simplified placeholder -->
<div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1" aria-labelledby="settings-offcanvas">
    <div class="offcanvas-header settings-panel-header justify-content-between bg-shape">
        <div class="z-1 py-1">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h5 class="text-white mb-0 me-2"><span class="fas fa-palette me-2 fs-9"></span>Settings</h5>
                <button class="btn btn-primary btn-sm rounded-pill mt-0 mb-0" data-theme-control="reset" style="font-size:12px">
                    <span class="fas fa-redo-alt me-1" data-fa-transform="shrink-3"></span>Reset
                </button>
            </div>
            <p class="mb-0 fs-10 text-white opacity-75">Set your own customized style</p>
        </div>
        <div class="z-1" data-bs-theme="dark">
            <button class="btn-close z-1 mt-0" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>
    <div class="offcanvas-body scrollbar-overlay px-x1 h-100" id="themeController">
        <!-- Full Falcon offcanvas content would go here; we'll keep minimal for brevity -->
        <p>Theme settings panel – replace with actual Falcon offcanvas HTML.</p>
    </div>
</div>
<a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
    <!-- toggle button content -->
</a>
```

#### **Authentication Views**

##### **app/Views/auth/login.php**
```php
<div class="row flex-center min-vh-100 py-6">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <a class="d-flex flex-center mb-4" href="/">
            <img class="me-2" src="/assets/img/icons/spot-illustrations/falcon.png" alt="" width="58" />
            <span class="font-sans-serif text-primary fw-bolder fs-4 d-inline-block">falcon</span>
        </a>
        <div class="card">
            <div class="card-body p-4 p-sm-5">
                <div class="row flex-between-center mb-2">
                    <div class="col-auto">
                        <h5>Log in</h5>
                    </div>
                    <div class="col-auto fs-10 text-600">
                        <span class="mb-0">or</span>
                        <span><a href="/register">Create an account</a></span>
                    </div>
                </div>
                <?php if ($error = \App\Core\Session::flash('error')): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <?php if ($success = \App\Core\Session::flash('success')): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php endif; ?>
                <?php if ($errors = \App\Core\Session::flash('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $field => $msgs): ?>
                                <?php foreach ($msgs as $msg): ?>
                                    <li><?= $msg ?></li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="POST" action="/login">
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::generate(); ?>">
                    <div class="mb-3">
                        <input class="form-control" type="email" name="email" placeholder="Email address" value="<?= htmlspecialchars(\App\Core\Session::flash('old')['email'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label mb-0" for="remember">Remember me</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a class="fs-10" href="/forgot-password">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-block w-100 mt-3" type="submit">Log in</button>
                    </div>
                </form>
                <div class="position-relative mt-4">
                    <hr />
                    <div class="divider-content-center">or log in with</div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-sm-6">
                        <a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#">
                            <span class="fab fa-google-plus-g me-2"></span> google
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-outline-facebook btn-sm d-block w-100" href="#">
                            <span class="fab fa-facebook-square me-2"></span> facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

##### **app/Views/auth/register.php**
```php
<div class="row flex-center min-vh-100 py-6">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <a class="d-flex flex-center mb-4" href="/">
            <img class="me-2" src="/assets/img/icons/spot-illustrations/falcon.png" alt="" width="58" />
            <span class="font-sans-serif text-primary fw-bolder fs-4 d-inline-block">falcon</span>
        </a>
        <div class="card">
            <div class="card-body p-4 p-sm-5">
                <h5 class="mb-0">Register</h5>
                <small>Create your account</small>
                <?php if ($error = \App\Core\Session::flash('error')): ?>
                    <div class="alert alert-danger mt-3"><?= $error ?></div>
                <?php endif; ?>
                <?php if ($errors = \App\Core\Session::flash('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $field => $msgs): ?>
                                <?php foreach ($msgs as $msg): ?>
                                    <li><?= $msg ?></li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="POST" action="/register" class="mt-3">
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::generate(); ?>">
                    <div class="mb-3">
                        <input class="form-control" type="text" name="name" placeholder="Full name" value="<?= htmlspecialchars(\App\Core\Session::flash('old')['name'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="email" name="email" placeholder="Email address" value="<?= htmlspecialchars(\App\Core\Session::flash('old')['email'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="password" name="password_confirm" placeholder="Confirm password" required>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-block w-100" type="submit">Register</button>
                    </div>
                </form>
                <a class="fs-10" href="/login">Already have an account? Log in</a>
            </div>
        </div>
    </div>
</div>
```

##### **app/Views/auth/forgot-password.php**
```php
<div class="row flex-center min-vh-100 py-6">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <a class="d-flex flex-center mb-4" href="/">
            <img class="me-2" src="/assets/img/icons/spot-illustrations/falcon.png" alt="" width="58" />
            <span class="font-sans-serif text-primary fw-bolder fs-4 d-inline-block">falcon</span>
        </a>
        <div class="card">
            <div class="card-body p-4 p-sm-5">
                <h5 class="mb-0">Forgot password?</h5>
                <small>Enter your email to reset your password.</small>
                <?php if ($error = \App\Core\Session::flash('error')): ?>
                    <div class="alert alert-danger mt-3"><?= $error ?></div>
                <?php endif; ?>
                <?php if ($success = \App\Core\Session::flash('success')): ?>
                    <div class="alert alert-success mt-3"><?= $success ?></div>
                <?php endif; ?>
                <form method="POST" action="/forgot-password" class="mt-3">
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::generate(); ?>">
                    <div class="mb-3">
                        <input class="form-control" type="email" name="email" placeholder="Email address" required>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-block w-100" type="submit">Send reset link</button>
                    </div>
                </form>
                <a class="fs-10" href="/login">Back to login</a>
            </div>
        </div>
    </div>
</div>
```

##### **app/Views/auth/confirm-mail.php**
```php
<div class="row flex-center min-vh-100 py-6">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <a class="d-flex flex-center mb-4" href="/">
            <img class="me-2" src="/assets/img/icons/spot-illustrations/falcon.png" alt="" width="58" />
            <span class="font-sans-serif text-primary fw-bolder fs-4 d-inline-block">falcon</span>
        </a>
        <div class="card">
            <div class="card-body p-4 p-sm-5 text-center">
                <div class="mb-4">
                    <span class="fas fa-envelope-open-text fs-1 text-primary"></span>
                </div>
                <h5 class="mb-3">Please check your email!</h5>
                <p class="fs-10">
                    An email has been sent to <strong><?= \App\Core\Session::flash('reset_email') ?? 'your email' ?></strong>.
                    Please click on the included link to reset your password.
                </p>
                <a class="btn btn-primary btn-sm mt-3" href="/login">
                    <span class="fas fa-arrow-left me-2"></span> Back to login
                </a>
                <?php if ($token = \App\Core\Session::flash('reset_token')): ?>
                    <div class="mt-3">
                        <a href="/reset-password?token=<?= $token ?>" class="btn btn-warning btn-sm">Test Reset Link</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
```

##### **app/Views/auth/reset-password.php**
```php
<div class="row flex-center min-vh-100 py-6">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <a class="d-flex flex-center mb-4" href="/">
            <img class="me-2" src="/assets/img/icons/spot-illustrations/falcon.png" alt="" width="58" />
            <span class="font-sans-serif text-primary fw-bolder fs-4 d-inline-block">falcon</span>
        </a>
        <div class="card">
            <div class="card-body p-4 p-sm-5">
                <h5 class="mb-0">Reset password</h5>
                <small>Enter your new password below.</small>
                <?php if ($error = \App\Core\Session::flash('error')): ?>
                    <div class="alert alert-danger mt-3"><?= $error ?></div>
                <?php endif; ?>
                <?php if ($errors = \App\Core\Session::flash('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $field => $msgs): ?>
                                <?php foreach ($msgs as $msg): ?>
                                    <li><?= $msg ?></li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="POST" action="/reset-password" class="mt-3">
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::generate(); ?>">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
                    <div class="mb-3">
                        <input class="form-control" type="password" name="password" placeholder="New password" required>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="password" name="password_confirm" placeholder="Confirm new password" required>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-block w-100" type="submit">Reset password</button>
                    </div>
                </form>
                <a class="fs-10" href="/login">Back to login</a>
            </div>
        </div>
    </div>
</div>
```

##### **app/Views/auth/logout.php**
```php
<div class="row flex-center min-vh-100 py-6">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <a class="d-flex flex-center mb-4" href="/">
            <img class="me-2" src="/assets/img/icons/spot-illustrations/falcon.png" alt="" width="58" />
            <span class="font-sans-serif text-primary fw-bolder fs-4 d-inline-block">falcon</span>
        </a>
        <div class="card">
            <div class="card-body p-4 p-sm-5 text-center">
                <h5 class="mb-3">You have been logged out</h5>
                <p class="fs-10">Thank you for using our application.</p>
                <a class="btn btn-primary btn-sm mt-3" href="/login">
                    <span class="fas fa-sign-in-alt me-2"></span> Log in again
                </a>
                <div class="mt-3">
                    <a href="/lock-screen" class="fs-10">Lock screen test</a>
                </div>
            </div>
        </div>
    </div>
</div>
```

##### **app/Views/auth/lock-screen.php**
```php
<div class="row flex-center min-vh-100 py-6">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <a class="d-flex flex-center mb-4" href="/">
            <img class="me-2" src="/assets/img/icons/spot-illustrations/falcon.png" alt="" width="58" />
            <span class="font-sans-serif text-primary fw-bolder fs-4 d-inline-block">falcon</span>
        </a>
        <div class="card">
            <div class="card-body p-4 p-sm-5 text-center">
                <img class="img-thumbnail rounded-circle mb-3" src="/assets/img/team/avatar.jpg" alt="" width="80" />
                <h5 class="mb-2"><?= \App\Core\Session::get('user_name') ?></h5>
                <p class="fs-10 mb-3">Enter your password to unlock</p>
                <?php if ($error = \App\Core\Session::flash('error')): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="POST" action="/unlock">
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Csrf::generate(); ?>">
                    <div class="mb-3">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-block w-100" type="submit">Unlock</button>
                    </div>
                </form>
                <a class="fs-10" href="/logout">Sign in as a different user</a>
            </div>
        </div>
    </div>
</div>
```

#### **Dashboard View**

##### **app/Views/dashboard/index.php**
```php
<?php $currentPage = 'dashboard'; ?>
<h1>Dashboard</h1>
<p>Welcome, <?= \App\Core\Session::get('user_name') ?>!</p>
<p>Your role: <?= \App\Core\Session::get('user_role') ?></p>
```

#### **Error Views**

##### **app/Views/errors/404.php**
```php
<div class="row flex-center min-vh-100 py-6 text-center">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xxl-5">
        <a class="d-flex flex-center mb-4" href="/">
            <img class="me-2" src="/assets/img/icons/spot-illustrations/falcon.png" alt="" width="58" />
            <span class="font-sans-serif text-primary fw-bolder fs-4 d-inline-block">falcon</span>
        </a>
        <div class="card">
            <div class="card-body p-4 p-sm-5">
                <div class="fw-black lh-1 text-300 fs-error">404</div>
                <p class="lead mt-4 text-800 font-sans-serif fw-semi-bold">The page you're looking for is not found.</p>
                <hr />
                <p>Make sure the address is correct and that the page hasn't moved.</p>
                <a class="btn btn-primary btn-sm mt-3" href="/login">
                    <span class="fas fa-home me-2"></span> Take me home
                </a>
            </div>
        </div>
    </div>
</div>
```

##### **app/Views/errors/500.php**
```php
<div class="row flex-center min-vh-100 py-6 text-center">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xxl-5">
        <a class="d-flex flex-center mb-4" href="/">
            <img class="me-2" src="/assets/img/icons/spot-illustrations/falcon.png" alt="" width="58" />
            <span class="font-sans-serif text-primary fw-bolder fs-4 d-inline-block">falcon</span>
        </a>
        <div class="card">
            <div class="card-body p-4 p-sm-5">
                <div class="fw-black lh-1 text-300 fs-error">500</div>
                <p class="lead mt-4 text-800 font-sans-serif fw-semi-bold">Something went wrong on our server.</p>
                <hr />
                <p>We're working to fix the issue. Please try again later.</p>
                <a class="btn btn-primary btn-sm mt-3" href="/login">
                    <span class="fas fa-home me-2"></span> Take me home
                </a>
            </div>
        </div>
    </div>
</div>
```

---

### 13. Routes

#### **routes/web.php**
```php
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

// Protected routes
$router->post('/logout', 'AuthController@logout', [AuthMiddleware::class]);
$router->get('/logout', 'AuthController@logoutPage', [GuestMiddleware::class]); // logout page is guest

$router->get('/lock-screen', 'AuthController@lockScreen', [AuthMiddleware::class]);
$router->post('/unlock', 'AuthController@doUnlock', [AuthMiddleware::class]);

$router->get('/dashboard', 'DashboardController@index', [AuthMiddleware::class]);

// Admin-only route example
$router->get('/admin/users', 'AdminController@index', [AuthMiddleware::class, [RoleMiddleware::class, 'admin']]);
```

---

## 🚀 Setup Instructions

1. **Create the folder structure** exactly as shown.
2. **Copy all the code** into the respective files.
3. In the project root, run:
   ```bash
   composer install
   ```
4. **Copy `.env.example` to `.env`** and update with your database credentials.
5. **Import the SQL schema** (provided above) into your MySQL database.
6. **Place the Falcon template assets** into `public/assets/` and `public/vendors/` (if you don't have them, the pages will still work but without styling – you can temporarily remove the CSS/JS links).
7. **Start the built-in PHP server**:
   ```bash
   php -S localhost:8000 -t public
   ```
8. Open `http://localhost:8000` in your browser. You should see the login page.
9. **Test the system** with:
   - Admin: `admin@example.com` / `password`
   - User: `user@example.com` / `password`

You now have a complete, secure authentication foundation. From here, you can build the rest of the Leave Management System (employees, leaves, holidays, etc.) following the same MVC pattern.

If you need help adding those features, just ask! This guide is designed to be friendly and supportive – you're doing great!</content>
<parameter name="filePath">c:\xampp\htdocs\dashboard\PHP VERSION\STATE-DEPARTMENT-FOR-ENERGY-LEAVE-MANAGEMENT-PHP\authentication-system-guide.md