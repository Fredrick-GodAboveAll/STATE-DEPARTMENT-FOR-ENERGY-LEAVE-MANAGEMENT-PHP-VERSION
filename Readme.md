# LEAVE MANAGEMENT SYSTEM - PHP BASED VERSION

A comprehensive Leave Management System built with PHP, designed for the State Department for Energy to manage employee leave requests, holidays, and related administrative tasks.

---

## Project Structure

```
STATE-DEPARTMENT-FOR-ENERGY-LEAVE-MANAGEMENT-PHP/
│
├── app/                               # Main application code directory
│   │
│   ├── Controllers/                   # Handles request logic and business operations
│   │   ├── Controller.php             # Base controller class - parent for all controllers
│   │   ├── AuthController.php         # Authentication/Login/Logout operations
│   │   ├── AppController.php          # General application controller
│   │   ├── ApiController.php          # API endpoints and data responses
│   │   ├── DashboardController.php    # Dashboard data and statistics
│   │   ├── DepartmentController.php   # Department management (CRUD operations)
│   │   ├── EmployeeController.php     # Employee management and profiles
│   │   ├── LeaveController.php        # Leave request processing and management
│   │   └── HolidaysController.php     # Holiday setup and management
│   │
│   ├── Models/                        # Database layer - data access and queries
│   │   ├── Model.php                  # Base model class with common DB methods
│   │   ├── User.php                   # User/Admin data model
│   │   ├── Employee.php               # Employee information model
│   │   └── Holiday.php                # Holiday calendar data model
│   │
│   ├── Views/                         # UI Templates - HTML/PHP templates
│   │   ├── layouts/                   # Layout templates for page structure
│   │   │   ├── auth.php               # Layout for authentication pages (login, register)
│   │   │   └── [other layout files]   # Main application layout templates
│   │   │
│   │   ├── apps/                      # App-related view files
│   │   ├── auth/                      # Authentication views (login, register, password reset)
│   │   ├── dashboard/                 # Dashboard views (statistics, reports, overview)
│   │   ├── departments/               # Department management views
│   │   ├── employees/                 # Employee list, profile, management pages
│   │   ├── leave_management/          # Leave types, leave rules, leave limits configuration
│   │   ├── errors/                    # Error pages (404, 500, etc.)
│   │   └── user/                      # User profile, settings, preferences pages
│   │
│   ├── Middleware/                    # Request/Response filters and validators
│   │   ├── AuthMiddleware.php         # Verifies user authentication and authorization
│   │   ├── UserMiddleware.php         # User-related middleware (role checks, permissions)
│   │   ├── ErrorMiddleware.php        # Global error handling and logging
│   │   ├── FlashMiddleware.php        # Flash message handling for notifications
│   │   └── multer.js                  # File upload middleware (for frontend/Node integration)
│   │
│   ├── Core/                          # Core framework files - foundation classes
│   │   ├── Router.php                 # URL routing and request dispatching
│   │   └── Session.php                # Session management and storage
│   │
│   └── Utils/                         # Utility functions and helpers
│       └── Validator.php              # Input validation rules and methods
│
├── config/                            # Configuration files
│   ├── database.php                   # Database connection settings and credentials
│   ├── constants.php                  # Application-wide constants and settings
│   ├── database.sql                   # Database schema and initial data
│   └── email.config.js                # Email configuration (SMTP, templates)
│
├── routes/                            # Application routing
│   └── web.php                        # Web route definitions (maps URLs to controllers)
│
├── services/                          # Business logic services
│   └── email.service.js               # Email sending service (notifications, confirmations)
│
├── Storage/                           # File storage and uploads
│   └── Uploads.php                    # Handles file uploads and storage operations
│
├── database/                          # Database related files
│   └── [empty - reserved for migrations and backup]
│
├── public/                            # Web root - publicly accessible files
│   ├── index.php                      # Application entry point
│   ├── assets/                        # Static assets (CSS, JS, images)
│   ├── fonts/                         # Font files and icon libraries
│   └── vendors/                       # Third-party libraries and dependencies
│
├── simple/                            # Simple HTML templates (standalone pages)
│   ├── confirm-mail.html              # Email confirmation page
│   ├── forgot-password.html           # Password recovery form
│   ├── lock-screen.html               # Screen lock/timeout page
│   ├── login.html                     # Login form template
│   ├── logout.html                    # Logout confirmation page
│   ├── register.html                  # User registration form
│   └── reset-password.html            # Password reset form
│
├── transfer/                          # Design transfer files (development/reference)
│   └── Falcon Dashboard templates     # Template backups and design references
│
├── vendor/                            # Composer dependencies (auto-generated)
│   ├── autoload.php                   # Composer autoloader
│   └── composer/                      # Composer metadata
│
├── composer.json                      # PHP dependency manager configuration
├── composer.lock                      # Locked dependency versions
├── .env                               # Environment variables (local configuration)
├── .env.example                       # Example environment file template
├── .gitignore                         # Git ignore rules
├── .git/                              # Git version control
└── Readme.md                          # Project documentation (this file)
```

---

## Directory & File Descriptions

### `/app` - Main Application Logic
Contains all core application code following MVC (Model-View-Controller) architecture pattern.

#### `/app/Controllers` - Request Handlers
Controllers process incoming HTTP requests and coordinate between models and views:
- **Controller.php** - Base controller with shared functionality for all controllers
- **AuthController.php** - Handles user login, logout, session management, authentication
- **AppController.php** - General application operations and common features
- **ApiController.php** - REST API endpoints for AJAX/frontend requests
- **DashboardController.php** - Generates dashboard data, statistics, and reports
- **DepartmentController.php** - Department CRUD operations and management
- **EmployeeController.php** - Employee records, profiles, and management operations
- **LeaveController.php** - Leave request submission, approval, tracking, and management
- **HolidaysController.php** - Holiday calendar configuration and management

#### `/app/Models` - Database Access Layer
Models handle database queries, data operations, and business logic:
- **Model.php** - Base model class with common database methods (find, create, update, delete)
- **User.php** - User/Admin authentication and profile data management
- **Employee.php** - Employee records, information, and details
- **Holiday.php** - Holiday definitions and leave type configurations

#### `/app/Views` - UI Templates
HTML/PHP template files for rendering pages and user interfaces:
- **layouts/** - Page layout templates (headers, footers, navigation)
  - *auth.php* - Authentication page layout for login/register pages
- **apps/** - App-related view files
- **auth/** - Login, registration, password recovery pages
- **dashboard/** - Dashboard statistics, overview, and reporting pages
- **departments/** - Department listing and management interfaces
- **employees/** - Employee list, profiles, management, and details pages
- **leave_management/** - Leave type setup, rules, limits, and policy configuration
- **errors/** - Error pages (404, 500, access denied, maintenance, etc.)
- **user/** - User profile, settings, preferences, and account pages

#### `/app/Middleware` - Request Filters
Middleware processes requests before they reach controllers:
- **AuthMiddleware.php** - Verifies user authentication status and redirects unauthenticated users
- **UserMiddleware.php** - Validates user roles and permissions for protected actions
- **ErrorMiddleware.php** - Global error handling, logging, and error page display
- **FlashMiddleware.php** - Manages flash messages for notifications, alerts, and feedback
- **multer.js** - File upload middleware for frontend/Node.js integration

#### `/app/Core` - Framework Foundation
Core framework classes providing base functionality:
- **Router.php** - URL routing engine, request dispatching to appropriate controllers and actions
- **Session.php** - Session initialization, management, user state storage and retrieval

#### `/app/Utils` - Helper Functions
Utility functions and helper classes for common operations:
- **Validator.php** - Input validation rules, data sanitization, and error message generation

### `/config` - Configuration Files
Application settings, environment configuration, and database schemas:
- **database.php** - Database connection credentials, host, username, password, settings
- **constants.php** - Application-wide constants (app name, version, settings, etc.)
- **database.sql** - Database schema, table definitions, and initial seed data
- **email.config.js** - Email service configuration (SMTP server, sender details, templates)

### `/routes` - Application Routes
URL routing configuration files:
- **web.php** - Defines all URL routes and maps them to appropriate controllers/actions

### `/services` - Business Logic Services
Reusable services for common operations across the application:
- **email.service.js** - Email sending service for notifications, confirmations, and alerts

### `/Storage` - File Management
File storage and upload handling:
- **Uploads.php** - Handles user file uploads, storage operations, and file management

### `/database` - Database Files
Database migration and backup directory:
- Empty by default, reserved for database migrations, backups, and schema updates

### `/simple` - Standalone HTML Templates
Simple, standalone HTML pages not integrated into main application:
- **confirm-mail.html** - Email confirmation page template
- **forgot-password.html** - Password recovery/reset form template
- **lock-screen.html** - Screen lock or session timeout page
- **login.html** - Standalone login form template
- **logout.html** - Logout confirmation page
- **register.html** - User registration form template
- **reset-password.html** - Password reset form template

### `/transfer` - Design/Template Files
Development/reference files for UI templates and design assets:
- Contains Falcon Dashboard template backups and design references for UI consistency

### `/vendor` - Dependencies
Auto-generated Composer dependency directory (do not edit manually):
- **autoload.php** - Composer's PSR-4 autoloader for automatic class loading
- **composer/** - Composer metadata and installed package information

### Root Configuration Files
- **composer.json** - PHP dependency specifications and project metadata
- **composer.lock** - Locked versions of all dependencies for consistency across environments
- **.env** - Environment variables for local configuration (sensitive data, API keys)
- **.env.example** - Template showing required environment variables
- **.gitignore** - Specifies files/folders to exclude from git version control
- **.git/** - Git version control repository and history
- **Readme.md** - Project documentation (this file)

---

## Key Features
✓ Employee leave request management and tracking
✓ Holiday calendar management
✓ Department administration and organization
✓ Leave approval workflow
✓ Responsive dashboard with statistics
✓ User authentication and authorization
✓ Email notifications and alerts
✓ Data export capabilities
✓ Role-based access control
✓ Employee performance tracking

## Setup Instructions

1. **Install Dependencies**
   ```bash
   composer install
   ```

2. **Configure Environment**
   - Copy `.env.example` to `.env`
   - Update database credentials and settings

3. **Database Setup**
   - Import `config/database.sql` into your MySQL/MariaDB database
   - Update connection settings in `config/database.php`
   - Test database connection

4. **Run Application**
   - Place project in web root (XAMPP htdocs)
   - Access via `http://localhost/STATE-DEPARTMENT-FOR-ENERGY-LEAVE-MANAGEMENT-PHP/public`
   - Login with default credentials (check database.sql)

---

## Technologies Used
- **Backend**: PHP 7.4+
- **Frontend**: HTML5, CSS3, JavaScript ES6+, Bootstrap 5
- **Database**: MySQL 5.7+ or MariaDB
- **Libraries**: DataTables, Chart.js, Select2, Day.js, ECharts, FontAwesome, Feather Icons
- **Package Manager**: Composer
- **Version Control**: Git

---

## Development Notes

### Code Structure
- Follows MVC (Model-View-Controller) architectural pattern
- Models handle data access and business logic
- Controllers manage request routing and application flow
- Views present data to users through HTML templates

### Database
- Primary database: MySQL/MariaDB
- Schema defined in `config/database.sql`
- Models handle all database interactions via prepared statements

### Security
- Authentication middleware protects routes
- Input validation through Validator utility
- CSRF protection on forms
- User roles and permissions enforced

---

## Support & Maintenance
For issues or enhancements, refer to the controllers, models, and views that handle specific functionality. Configuration settings are centralized in the `/config` directory for easy management.


## to start the project simply 
C:\xampp\htdocs\dashboard\PHP VERSION\STATE-DEPARTMENT-FOR-ENERGY-LEAVE-MANAGEMENT-PHP>php -S localhost:8000 -t public


