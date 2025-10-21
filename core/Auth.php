<?php
namespace Core;

use Models\User;

class Auth
{
    public static function user(): ?array
    {
        Helpers::session();
        if (!empty($_SESSION['user_id'])) {
            $userModel = new User();
            return $userModel->findById((int)$_SESSION['user_id']);
        }
        return null;
    }

    public static function attempt(string $email, string $password): bool
    {
        $userModel = new User();
        $user = $userModel->findByEmail($email);
        if ($user && password_verify($password, $user['password_hash'])) {
            Helpers::session();
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }

    public static function logout(): void
    {
        Helpers::session();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function requireAdmin(): void
    {
        $user = self::user();
        if (!$user || $user['role'] !== 'admin') {
            http_response_code(403);
            echo View::render('errors/403', []);
            exit;
        }
    }
}
