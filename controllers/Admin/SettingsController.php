<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\View;
use Models\Setting;

class SettingsController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $settingModel = new Setting();
        View::make('admin/settings/index', [
            'branding' => $settingModel->get('branding', []),
            'mail' => $settingModel->get('mail', []),
            'payment' => $settingModel->get('payment', []),
        ]);
    }

    public function update(): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $pdo = require __DIR__ . '/../../config/db.php';
        $stmt = $pdo->prepare('INSERT INTO settings (`key`, `value`) VALUES (:key, :value) ON DUPLICATE KEY UPDATE value = VALUES(value)');
        foreach (['branding', 'mail', 'payment'] as $group) {
            $stmt->execute([
                'key' => $group,
                'value' => json_encode($_POST[$group] ?? [])
            ]);
        }
        Helpers::setFlash('admin', 'Ayarlar güncellendi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/settings'));
    }
}
