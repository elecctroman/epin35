<?php
namespace Core;

class View
{
    public static function render(string $view, array $data = []): string
    {
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \RuntimeException('View not found: ' . $view);
        }
        extract($data, EXTR_SKIP);
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }

    public static function make(string $view, array $data = []): void
    {
        echo self::render($view, $data);
    }
}
