<?php
namespace Core;

class Helpers
{
    public static function baseUrl(string $path = ''): string
    {
        $config = require __DIR__ . '/../config/config.php';
        return rtrim($config['base_url'], '/') . '/' . ltrim($path, '/');
    }

    public static function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    public static function csrfField(): string
    {
        return '<input type="hidden" name="_token" value="' . self::e(Csrf::token()) . '">';
    }

    public static function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }

    public static function asset(string $path): string
    {
        return self::baseUrl('assets/' . ltrim($path, '/'));
    }

    public static function session(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            $config = require __DIR__ . '/../config/config.php';
            $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
            session_name($config['security']['session_name']);
            session_set_cookie_params([
                'httponly' => true,
                'secure' => $secure,
                'samesite' => 'Lax',
                'path' => '/',
            ]);
            session_start();
        }
        return $_SESSION;
    }

    public static function setFlash(string $key, string $message, string $type = 'info'): void
    {
        self::session();
        $_SESSION['flash'][$key] = ['message' => $message, 'type' => $type];
    }

    public static function getFlash(?string $key = null): array
    {
        self::session();
        if ($key !== null) {
            $message = $_SESSION['flash'][$key] ?? null;
            unset($_SESSION['flash'][$key]);
            return $message ? [$message] : [];
        }
        $flash = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $flash;
    }

    public static function formatCurrency(float $amount, string $currency = '₺'): string
    {
        return $currency . number_format($amount, 2, ',', '.');
    }

    public static function pagination(int $total, int $perPage, int $page): array
    {
        $pages = (int)ceil(max($total, 1) / max($perPage, 1));
        return [
            'total' => $total,
            'pages' => $pages,
            'current' => max(min($page, $pages), 1),
        ];
    }

    public static function currentPath(): string
    {
        return parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    }

    public static function activeNav(string $path): string
    {
        $current = self::currentPath();
        return str_starts_with($current, $path) ? 'is-active' : '';
    }

    public static function navCategories(): array
    {
        static $cache;
        if ($cache === null) {
            $model = new \Models\Category();
            $cache = $model->featured();
        }
        return $cache;
    }
}
