<?php
namespace App\Core;

class Session
{
    /**
     * Set a flash message
     */
    public static function flash($key, $message)
    {
        $_SESSION['_flash'][$key] = $message;
    }

    /**
     * Get and clear flash message
     */
    public static function getFlash($key)
    {
        if (isset($_SESSION['_flash'][$key])) {
            $message = $_SESSION['_flash'][$key];
            unset($_SESSION['_flash'][$key]);
            return $message;
        }
        return null;
    }

    /**
     * Get all flash data and clear
     */
    public static function consumeFlash()
    {
        $flash = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);
        return $flash;
    }

    /**
     * Regenerate session ID to prevent fixation
     */
    public static function regenerate()
    {
        session_regenerate_id(true);
    }

    /**
     * Set user session
     */
    public static function setUser($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
    }

    /**
     * Check if user is logged in
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Get user data
     */
    public static function user()
    {
        if (!self::isLoggedIn()) return null;
        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email']
        ];
    }

    /**
     * Destroy session (logout)
     */
    public static function destroy()
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}