<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\View;
use Models\Vendor;

class VendorsController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $vendorModel = new Vendor();
        View::make('admin/vendors/index', [
            'vendors' => $vendorModel->top(50)
        ]);
    }
}
