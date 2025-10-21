<?php
$config = require __DIR__ . '/config/config.php';
date_default_timezone_set($config['timezone']);

require_once __DIR__ . '/core/Autoloader.php';
\Core\Autoloader::register();

\Core\Helpers::session();

$router = new \Core\Router();

$authMiddleware = function ($request, $next) {
    if (!\Core\Auth::check()) {
        \Core\Helpers::redirect(\Core\Helpers::baseUrl('login'));
    }
    return $next($request);
};

$adminMiddleware = function ($request, $next) {
    \Core\Auth::requireAdmin();
    return $next($request);
};

$router->add('GET', '/', function ($request, $params = []) {
    (new \Controllers\HomeController())->index();
});

$router->add('GET', '/urun/{slug}', function ($request, $params) {
    (new \Controllers\ProductController())->show($params['slug']);
});

$router->add('GET', '/kategori/{slug}', function ($request, $params) {
    (new \Controllers\CategoryController())->show($params['slug']);
});

$router->add('GET', '/search', function ($request, $params = []) {
    (new \Controllers\SearchController())->index();
});

$router->add('GET', '/cart', function ($request, $params = []) {
    (new \Controllers\CartController())->index();
});

$router->add('POST', '/cart/add', function ($request, $params = []) {
    (new \Controllers\CartController())->add();
});

$router->add('POST', '/cart/remove/{id}', function ($request, $params) {
    (new \Controllers\CartController())->remove((int)$params['id']);
});

$router->add('GET', '/checkout', function ($request, $params = []) {
    (new \Controllers\CheckoutController())->index();
});

$router->add('POST', '/checkout', function ($request, $params = []) {
    (new \Controllers\CheckoutController())->process();
});

$router->add('GET', '/account', function ($request, $params = []) {
    (new \Controllers\AccountController())->index();
}, [$authMiddleware]);

$router->add('GET', '/login', function ($request, $params = []) {
    (new \Controllers\AccountController())->loginForm();
});

$router->add('POST', '/login', function ($request, $params = []) {
    (new \Controllers\AccountController())->login();
});

$router->add('GET', '/logout', function ($request, $params = []) {
    (new \Controllers\AccountController())->logout();
}, [$authMiddleware]);

$router->add('GET', '/support', function ($request, $params = []) {
    (new \Controllers\SupportController())->index();
});

$router->add('POST', '/support', function ($request, $params = []) {
    (new \Controllers\SupportController())->create();
}, [$authMiddleware]);

$router->add('GET', '/admin', function ($request, $params = []) {
    (new \Controllers\Admin\DashboardController())->index();
}, [$adminMiddleware]);

$router->add('GET', '/admin/products', function ($request, $params = []) {
    (new \Controllers\Admin\ProductsController())->index();
}, [$adminMiddleware]);

$router->add('GET', '/admin/products/create', function ($request, $params = []) {
    (new \Controllers\Admin\ProductsController())->create();
}, [$adminMiddleware]);

$router->add('POST', '/admin/products', function ($request, $params = []) {
    (new \Controllers\Admin\ProductsController())->store();
}, [$adminMiddleware]);

$router->add('GET', '/admin/products/{id}/edit', function ($request, $params) {
    (new \Controllers\Admin\ProductsController())->edit((int)$params['id']);
}, [$adminMiddleware]);

$router->add('POST', '/admin/products/{id}/update', function ($request, $params) {
    (new \Controllers\Admin\ProductsController())->update((int)$params['id']);
}, [$adminMiddleware]);

$router->add('POST', '/admin/products/{id}/delete', function ($request, $params) {
    (new \Controllers\Admin\ProductsController())->destroy((int)$params['id']);
}, [$adminMiddleware]);

$router->add('POST', '/admin/products/{id}/toggle', function ($request, $params) {
    (new \Controllers\Admin\ProductsController())->toggle((int)$params['id']);
}, [$adminMiddleware]);

$router->add('GET', '/admin/categories', function ($request, $params = []) {
    (new \Controllers\Admin\CategoriesController())->index();
}, [$adminMiddleware]);

$router->add('POST', '/admin/categories', function ($request, $params = []) {
    (new \Controllers\Admin\CategoriesController())->store();
}, [$adminMiddleware]);

$router->add('GET', '/admin/categories/{id}/edit', function ($request, $params) {
    (new \Controllers\Admin\CategoriesController())->edit((int)$params['id']);
}, [$adminMiddleware]);

$router->add('POST', '/admin/categories/{id}/update', function ($request, $params) {
    (new \Controllers\Admin\CategoriesController())->update((int)$params['id']);
}, [$adminMiddleware]);

$router->add('POST', '/admin/categories/{id}/delete', function ($request, $params) {
    (new \Controllers\Admin\CategoriesController())->destroy((int)$params['id']);
}, [$adminMiddleware]);

$router->add('GET', '/admin/orders', function ($request, $params = []) {
    (new \Controllers\Admin\OrdersController())->index();
}, [$adminMiddleware]);

$router->add('GET', '/admin/orders/{id}', function ($request, $params) {
    (new \Controllers\Admin\OrdersController())->show((int)$params['id']);
}, [$adminMiddleware]);

$router->add('POST', '/admin/orders/{id}/status', function ($request, $params) {
    (new \Controllers\Admin\OrdersController())->updateStatus((int)$params['id']);
}, [$adminMiddleware]);

$router->add('GET', '/admin/users', function ($request, $params = []) {
    (new \Controllers\Admin\UsersController())->index();
}, [$adminMiddleware]);

$router->add('POST', '/admin/users/{id}/role', function ($request, $params) {
    (new \Controllers\Admin\UsersController())->updateRole((int)$params['id']);
}, [$adminMiddleware]);

$router->add('POST', '/admin/users/{id}/reset-2fa', function ($request, $params) {
    (new \Controllers\Admin\UsersController())->resetTwoFactor((int)$params['id']);
}, [$adminMiddleware]);

$router->add('GET', '/admin/coupons', function ($request, $params = []) {
    (new \Controllers\Admin\CouponsController())->index();
}, [$adminMiddleware]);

$router->add('POST', '/admin/coupons', function ($request, $params = []) {
    (new \Controllers\Admin\CouponsController())->store();
}, [$adminMiddleware]);

$router->add('GET', '/admin/coupons/{id}/edit', function ($request, $params) {
    (new \Controllers\Admin\CouponsController())->edit((int)$params['id']);
}, [$adminMiddleware]);

$router->add('POST', '/admin/coupons/{id}/update', function ($request, $params) {
    (new \Controllers\Admin\CouponsController())->update((int)$params['id']);
}, [$adminMiddleware]);

$router->add('POST', '/admin/coupons/{id}/delete', function ($request, $params) {
    (new \Controllers\Admin\CouponsController())->destroy((int)$params['id']);
}, [$adminMiddleware]);

$router->add('GET', '/admin/vendors', function ($request, $params = []) {
    (new \Controllers\Admin\VendorsController())->index();
}, [$adminMiddleware]);

$router->add('POST', '/admin/vendors', function ($request, $params = []) {
    (new \Controllers\Admin\VendorsController())->store();
}, [$adminMiddleware]);

$router->add('POST', '/admin/vendors/{id}/update', function ($request, $params) {
    (new \Controllers\Admin\VendorsController())->update((int)$params['id']);
}, [$adminMiddleware]);

$router->add('POST', '/admin/vendors/{id}/delete', function ($request, $params) {
    (new \Controllers\Admin\VendorsController())->destroy((int)$params['id']);
}, [$adminMiddleware]);

$router->add('GET', '/admin/settings', function ($request, $params = []) {
    (new \Controllers\Admin\SettingsController())->index();
}, [$adminMiddleware]);

$router->add('POST', '/admin/settings', function ($request, $params = []) {
    (new \Controllers\Admin\SettingsController())->update();
}, [$adminMiddleware]);

$router->add('GET', '/admin/banners', function ($request, $params = []) {
    (new \Controllers\Admin\BannersController())->index();
}, [$adminMiddleware]);

$router->add('POST', '/admin/banners', function ($request, $params = []) {
    (new \Controllers\Admin\BannersController())->store();
}, [$adminMiddleware]);

$router->add('POST', '/admin/banners/{id}/update', function ($request, $params) {
    (new \Controllers\Admin\BannersController())->update((int)$params['id']);
}, [$adminMiddleware]);

$router->add('POST', '/admin/banners/{id}/delete', function ($request, $params) {
    (new \Controllers\Admin\BannersController())->destroy((int)$params['id']);
}, [$adminMiddleware]);

$router->add('GET', '/admin/tickets', function ($request, $params = []) {
    (new \Controllers\Admin\TicketsController())->index();
}, [$adminMiddleware]);

$router->add('GET', '/admin/tickets/{id}', function ($request, $params) {
    (new \Controllers\Admin\TicketsController())->show((int)$params['id']);
}, [$adminMiddleware]);

$router->add('POST', '/admin/tickets/{id}/reply', function ($request, $params) {
    (new \Controllers\Admin\TicketsController())->reply((int)$params['id']);
}, [$adminMiddleware]);

$router->add('GET', '/admin/reports', function ($request, $params = []) {
    (new \Controllers\Admin\ReportsController())->index();
}, [$adminMiddleware]);

$router->dispatch();
