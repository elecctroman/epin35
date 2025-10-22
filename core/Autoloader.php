<?php
namespace Core;

class Autoloader
{
    private const PREFIXES = [
        'Core\\' => 'core',
        'Controllers\\Admin\\' => 'controllers/Admin',
        'Controllers\\' => 'controllers',
        'Models\\' => 'models',
    ];

    public static function register(): void
    {
        spl_autoload_register([self::class, 'load']);
    }

    private static function load(string $class): void
    {
        foreach (self::PREFIXES as $prefix => $directory) {
            if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
                continue;
            }

            $relative = substr($class, strlen($prefix));
            $relative = ltrim($relative, '\\');

            $basePath = __DIR__ . '/../' . $directory;
            $filePath = rtrim($basePath, '/') . ($relative !== '' ? '/' . str_replace('\\', '/', $relative) : '') . '.php';

            if (is_file($filePath)) {
                require_once $filePath;
                return;
            }

            $fallbackPath = rtrim($basePath, '/') . ($relative !== '' ? '/' . strtolower(str_replace('\\', '/', $relative)) : '') . '.php';
            if ($filePath !== $fallbackPath && is_file($fallbackPath)) {
                require_once $fallbackPath;
                return;
            }

            error_log(sprintf('Autoloader could not resolve %s (looked for %s)', $class, $filePath));
        }
    }
}
