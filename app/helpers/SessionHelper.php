<?php

class SessionHelper {
    public static function start() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        self::start();
        return $_SESSION[$key] ?? null;
    }

    public static function destroy() {
        self::start();
        session_destroy();
    }

    public static function isLoggedIn() {
        self::start();
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin() {
        self::start();
        return isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1;
    }

    public static function getRole() {
        self::start();
        return $_SESSION['role'] ?? 'guest';
    }

    public static function hasRole($role) {
        self::start();
        return isset($_SESSION['role']) && $_SESSION['role'] === $role;
    }

    public static function getUsername() {
        return isset($_SESSION['username']) ? $_SESSION['username'] : null;
    }

    public static function setUser($username, $role) {
        self::start();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
    }

    public static function clearUser() {
        self::start();
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        unset($_SESSION['user_id']);
        unset($_SESSION['is_admin']);
    }
}