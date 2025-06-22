<?php
require_once 'SessionHelper.php';

class AuthHelper {
    public static function isAdmin() {
        return SessionHelper::get('is_admin') === true;
    }

    public static function requireLogin() {
        if (!SessionHelper::get('user_id')) {
            header('Location: ?controller=auth&action=login');
            exit;
        }
    }
}
?>