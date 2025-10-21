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
            'checkout' => $settingModel->get('checkout', []),
            'security' => $settingModel->get('security', []),
        ]);
    }

    public function update(): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $settingModel = new Setting();
        $groups = ['branding', 'mail', 'payment', 'checkout', 'security'];
        foreach ($groups as $group) {
            $settingModel->set($group, $_POST[$group] ?? []);
        }
        Helpers::setFlash('admin', 'Ayarlar güncellendi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/settings'));
    }
}
