<?php
namespace Core;

class Csrf
{
    public static function token(): string
    {
        Helpers::session();
        if (empty($_SESSION['_csrf_token']) || $_SESSION['_csrf_expire'] < time()) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['_csrf_expire'] = time() + (require __DIR__ . '/../config/config.php')['security']['csrf_ttl'];
        }
        return $_SESSION['_csrf_token'];
    }

    public static function validate(?string $token): bool
    {
        Helpers::session();
        $valid = isset($_SESSION['_csrf_token'], $_SESSION['_csrf_expire'])
            && hash_equals($_SESSION['_csrf_token'], (string)$token)
            && $_SESSION['_csrf_expire'] >= time();
        if ($valid) {
            unset($_SESSION['_csrf_token'], $_SESSION['_csrf_expire']);
        }
        return $valid;
    }
}
