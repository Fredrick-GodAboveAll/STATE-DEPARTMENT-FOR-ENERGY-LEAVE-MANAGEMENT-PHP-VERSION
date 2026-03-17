# LEAVE MANAGEMENT SYSTEM – Complete Documentation (v3)

A comprehensive, production‑ready PHP‑based Leave Management System built on a custom MVC architecture. It features secure authentication, role‑based access (admin/user), employee management, leave tracking, holiday management, and a modern responsive UI powered by the Falcon Bootstrap template.

---

## 📁 Project Structure

```
project-root/
│
├── app/
│   ├── Controllers/           # Handle HTTP requests and responses
│   │   ├── Controller.php     # Base controller
│   │   ├── AuthController.php # Login, logout, registration, password reset
│   │   ├── DashboardController.php
│   │   ├── EmployeeController.php
│   │   ├── LeaveController.php
│   │   ├── HolidayController.php
│   │   ├── DepartmentController.php
│   │   ├── LeaveTypeController.php
│   │   └── ErrorController.php
│   │
│   ├── Models/                 # Database interaction
│   │   ├── Model.php
│   │   ├── User.php
│   │   ├── PasswordReset.php
│   │   ├── Employee.php
│   │   ├── Leave.php
│   │   ├── Holiday.php
│   │   ├── Department.php
│   │   └── LeaveType.php
│   │
│   ├── Services/                # Business logic layer
│   │   ├── AuthService.php
│   │   ├── EmployeeService.php
│   │   ├── LeaveService.php
│   │   ├── HolidayService.php
│   │   ├── DepartmentService.php
│   │   └── LeaveTypeService.php
│   │
│   ├── Middleware/               # Request filters
│   │   ├── AuthMiddleware.php    # Ensures user is logged in
│   │   ├── GuestMiddleware.php   # Redirects if already logged in
│   │   └── RoleMiddleware.php    # Checks user role (admin/user)
│   │
│   ├── Core/                      # Framework foundation
│   │   ├── Router.php
│   │   ├── Database.php
│   │   ├── Session.php
│   │   ├── ErrorHandler.php
│   │   └── Csrf.php
│   │
│   ├── Utils/                      # Helpers
│   │   ├── Validator.php
│   │   └── Mailer.php
│   │
│   └── Views/                       # UI templates
│       ├── layouts/
│       │   ├── auth.php
│       │   ├── admin.php
│       │   └── partials/
│       │       ├── _navbar.php
│       │       └── _offcanvas.php
│       ├── auth/                    # Login, register, password reset pages
│       ├── dashboard/
│       ├── employees/
│       ├── leaves/
│       ├── holidays/
│       ├── departments/
│       ├── leave_types/
│       └── errors/                   # 404, 500 pages
│
├── config/                           # Configuration files
│   ├── app.php
│   ├── database.php
│   └── constants.php
│
├── routes/                           # Route definitions
│   └── web.php
│
├── public/                            # Web root
│   ├── index.php                      # Front controller
│   ├── .htaccess                       # Apache routing
│   ├── assets/                          # Compiled CSS, JS, images (Falcon template - included)
│   └── vendors/                         # Third‑party frontend libraries (Falcon template - included)
│
├── storage/                             # File storage
│   ├── logs/                              # Application logs
│   └── uploads/                           # User uploaded files
│
├── vendor/                                # Composer dependencies
│
├── .env                                   # Environment variables (not committed)
├── .env.example                           # Example environment file
├── composer.json                          # PHP dependencies
├── .gitignore                             # Git ignore rules
└── README.md                               # This file
```

---

## 🔐 Authentication & Role‑Based Access

The system implements a secure authentication module with:

- **Registration** (optional) and **login**.
- **Password reset** with secure tokens stored in `password_resets` table.
- **Session regeneration** after login.
- **CSRF protection** on all forms.
- **Role‑based access**: `admin` (full access) and `user` (limited access). The `RoleMiddleware` can be applied to routes to restrict access.

Default users (all passwords are `password`):
- **Admin**: `admin@example.com` (full system access)
- **User**: `user@example.com` (limited access)

---

## ⚙️ Core Components

| Component       | Responsibility |
|-----------------|----------------|
| **Router**      | Maps URLs to controllers, runs middleware, dispatches requests. |
| **Database**    | Singleton PDO connection with prepared statements. |
| **Session**     | Wrapper for `$_SESSION` with flash messaging. |
| **ErrorHandler**| Converts errors to exceptions, logs them, displays friendly 404/500 pages. |
| **Csrf**        | Generates and validates CSRF tokens. |
| **Validator**   | Validates input data against rules (required, email, min, confirmed, etc.). |
| **Mailer**      | Dummy email logger (replace with PHPMailer for production). |

---

## 🗄️ Database Schema

The database is named `leave_management`. Key tables:

- `users` – stores user credentials and roles (`admin`, `user`).
- `password_resets` – stores password reset tokens with expiry.
- `employees` – employee details linked to `users` and `departments`.
- `departments` – department list.
- `leave_types` – leave categories (Annual, Sick, etc.).
- `leaves` – leave records linked to employees and leave types.
- `holidays` – public holidays.

**Sample SQL Schema:**
```sql
-- Create database
CREATE DATABASE IF NOT EXISTS `leave_management`;
USE `leave_management`;

-- Users table
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'user') DEFAULT 'user',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Password resets table
CREATE TABLE `password_resets` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `expires_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Departments table
CREATE TABLE `departments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Employees table
CREATE TABLE `employees` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `department_id` INT,
    `employee_id` VARCHAR(50) UNIQUE,
    `phone` VARCHAR(20),
    `address` TEXT,
    `hire_date` DATE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL
);

-- Leave types table
CREATE TABLE `leave_types` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `days_allowed` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Leaves table
CREATE TABLE `leaves` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT NOT NULL,
    `leave_type_id` INT NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `days_requested` INT NOT NULL,
    `reason` TEXT,
    `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    `approved_by` INT,
    `approved_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`employee_id`) REFERENCES `employees`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`approved_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
);

-- Holidays table
CREATE TABLE `holidays` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `date` DATE NOT NULL,
    `description` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Admin User', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Regular User', 'user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

INSERT INTO `departments` (`name`, `description`) VALUES
('IT Department', 'Information Technology'),
('HR Department', 'Human Resources'),
('Finance Department', 'Financial Operations');

INSERT INTO `leave_types` (`name`, `description`, `days_allowed`) VALUES
('Annual Leave', 'Regular annual vacation', 25),
('Sick Leave', 'Medical leave', 10),
('Personal Leave', 'Personal matters', 5);
```

A complete SQL schema is provided in `config/database.sql`. Initial data includes sample users, departments, leave types, and test records.

---

## 🚀 Quick Start

### 1. Install Dependencies
Make sure you have [Composer](https://getcomposer.org/) installed, then run:
```bash
composer install
```

### 2. Configure Environment
Copy `.env.example` to `.env` and update the database credentials:

**Sample `.env` content:**
```ini
DB_HOST=localhost
DB_NAME=leave_management
DB_USER=root
DB_PASS=your_password_here
SESSION_SECRET=your_random_secret_key_here
EMAIL_HOST=smtp.gmail.com
EMAIL_USER=your_email@gmail.com
EMAIL_PASS=your_app_password
```

### 3. Create Database
Import the SQL schema (located in `database/schema.sql`) into your MySQL server.

### 4. Serve the Application
From the project root, run:
```bash
php -S localhost:8000 -t public
```
Then open `http://localhost:8000` in your browser.

---

## 🧪 Testing the Authentication

- Visit `/login` and log in with `admin@example.com` / `password` or `user@example.com` / `password`.
- After login you will be redirected to the dashboard.
- Use the lock screen (`/lock-screen`) to re‑authenticate.
- Test the password reset flow via `/forgot-password` (emails are logged in `storage/logs/email.log`).

---

## 🛡️ Security Features

- **Password hashing** with `password_hash()` (bcrypt).
- **CSRF tokens** on all POST forms.
- **Session fixation protection** – session ID regenerated after login.
- **Prepared statements** – prevents SQL injection.
- **Role‑based middleware** – restricts access to admin pages.
- **Error handling** – no stack traces or sensitive info leaked in production.
- **Logging** – all errors and important events are logged.

---

## 🧩 Extending the System

To add new features (e.g., leave approval workflow, reports):

1. Create the necessary database table(s).
2. Build a **Model** for the new entity.
3. Create a **Service** class containing business logic.
4. Create a **Controller** to handle HTTP requests.
5. Add **Views** for the UI.
6. Define **routes** in `routes/web.php` and apply middleware as needed.
7. Update the navigation partial (`_navbar.php`) to include links.

All controllers should extend `App\Controllers\Controller`, and services should be instantiated in the controller's constructor or method.

---

## 📦 Dependencies

- **PHP** 7.4 or higher
- **MySQL** 5.7 or MariaDB
- **Composer**
- **PHPMailer** (optional, for real email sending)
- **vlucas/phpdotenv** (for environment variables)
- **Falcon Bootstrap Template** (frontend assets included in `public/assets/` and `public/vendors/`)

---

## 🤝 Contributing

Feel free to extend the system. If you find bugs or have feature requests, please open an issue or submit a pull request.

---

## 📄 License

This project is open‑source and available under the MIT License.

---

**Happy coding!** Build a robust leave management solution on this solid foundation.


