# Project Overview

This document explains the overall structure of the Leave Management project and the roles of the main folders and files.

## Project structure

- `public/` — the web entry point and static assets.
- `routes/` — defines the available URLs and the controller methods that handle them.
- `app/Controllers/` — contains controller classes that bridge HTTP requests to business logic.
- `app/Services/` — contains service classes for application logic such as auth and email.
- `app/Core/` — contains shared helpers such as routing, session handling, CSRF protection, and error handling.
- `app/Views/` — contains view templates used to render HTML pages.
- `config/` — stores configuration values such as database settings.
- `vendor/` — Composer dependencies.

## How a request is handled

1. The browser requests a page from `public/index.php`.
2. Autoloading and environment setup run.
3. `Session::start()` begins the PHP session.
4. `routes/web.php` registers all routes with the router.
5. The router matches the current URL and calls the correct controller method.
6. The controller validates input, uses services/models, and loads a view.
7. The view renders HTML and sends it back to the browser.

## Key files

- `public/index.php` — application bootstrap.
- `routes/web.php` — route definitions and middleware assignments.
- `app/Core/Router.php` — the request dispatcher.
- `app/Core/Session.php` — session helper and flash messaging.
- `app/Core/Csrf.php` — form security.
- `app/Controllers/AuthController.php` — authentication page and form handling.
- `app/Services/AuthService.php` — auth business rules.
- `app/Views/layouts/auth.php` — layout wrapper for auth pages.
- `app/Views/dashboard/index.php` — dashboard view.

## Middleware and protection

- `AuthMiddleware` ensures that only logged-in users can access protected routes such as `/dashboard`.
- `GuestMiddleware` prevents authenticated users from seeing login/register pages when they are already logged in.

## Useful guidance

- To add a new page, create a route in `routes/web.php`, add a controller method, and add a view template.
- To change the auth flow, update both the controller and the relevant view forms.
- If you need to debug, use `Session::flash()` messages and inspect the route definitions.
- Keep the `public/` folder for assets and web entry files only.

## How to use the project skill

Refer to `.github/skills/project/SKILL.md` for a quick summary of when to use this skill while working on the repository.
