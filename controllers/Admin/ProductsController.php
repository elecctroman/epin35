<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\Validator;
use Core\View;
use Models\Category;
use Models\Product;
use Models\ProductVariation;
use Models\StockItem;

class ProductsController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $productModel = new Product();
        $categoryModel = new Category();

        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 12;
        $filters = [
            'search' => trim($_GET['q'] ?? ''),
            'category_id' => $_GET['category_id'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];
        $total = $productModel->count($filters);
        $products = $productModel->paginate($filters, $perPage, ($page - 1) * $perPage);

        View::make('admin/products/index', [
            'products' => $products,
            'categories' => $categoryModel->all(),
            'filters' => $filters,
            'pagination' => Helpers::pagination($total, $perPage, $page),
        ]);
    }

    public function create(): void
    {
        Auth::requireAdmin();
        $categoryModel = new Category();
        View::make('admin/products/create', [
            'categories' => $categoryModel->all(),
        ]);
    }

    public function store(): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }

        $validator = new Validator();
        $data = [
            'name' => $_POST['name'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'description' => $_POST['description'] ?? '',
            'category_id' => (int)($_POST['category_id'] ?? 0),
            'cover' => $_POST['cover'] ?? null,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        $isValid = $validator->validate($data, [
            'name' => 'required|min:4',
            'slug' => 'required|min:4',
            'description' => 'required|min:10',
        ]);
        $variations = $this->prepareVariations();
        if (!$isValid || empty($variations)) {
            $message = 'Ürün kaydedilemedi. Lütfen tüm alanları doldurun.';
            if ($errors = $validator->errors()) {
                $flat = [];
                foreach ($errors as $fieldErrors) {
                    $flat = array_merge($flat, $fieldErrors);
                }
                if ($flat) {
                    $message = implode(' ', array_unique($flat));
                }
            }
            Helpers::setFlash('admin', $message, 'error');
            Helpers::redirect(Helpers::baseUrl('admin/products/create'));
        }

        $productModel = new Product();
        $variationModel = new ProductVariation();
        $stockModel = new StockItem();

        $productId = $productModel->create($data);

        foreach ($variations as $variation) {
            $codes = $variation['codes'];
            unset($variation['codes']);
            $variationId = $variationModel->create($productId, $variation);
            if (!empty($codes)) {
                $imported = $stockModel->importBulk($variationId, $codes);
                if ($imported) {
                    $variationModel->updateStock($variationId, max($variation['stock'], $imported));
                }
            }
        }

        Helpers::setFlash('admin', 'Ürün başarıyla oluşturuldu.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/products'));
    }

    public function edit(int $id): void
    {
        Auth::requireAdmin();
        $productModel = new Product();
        $categoryModel = new Category();
        $variationModel = new ProductVariation();

        $product = $productModel->findWithRelations($id);
        if (!$product) {
            http_response_code(404);
            exit('Ürün bulunamadı');
        }

        foreach ($product['variations'] as &$variation) {
            $variation['codes_preview'] = '';
        }

        View::make('admin/products/edit', [
            'product' => $product,
            'variations' => $variationModel->forProduct($id),
            'categories' => $categoryModel->all(),
        ]);
    }

    public function update(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }

        $productModel = new Product();
        $variationModel = new ProductVariation();
        $stockModel = new StockItem();
        $product = $productModel->find($id);
        if (!$product) {
            http_response_code(404);
            exit('Ürün bulunamadı');
        }

        $data = [
            'name' => $_POST['name'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'description' => $_POST['description'] ?? '',
            'category_id' => (int)($_POST['category_id'] ?? $product['category_id']),
            'cover' => $_POST['cover'] ?? null,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        $validator = new Validator();
        $isValid = $validator->validate($data, [
            'name' => 'required|min:4',
            'slug' => 'required|min:4',
            'description' => 'required|min:10',
        ]);
        $variations = $this->prepareVariations();
        if (!$isValid || empty($variations)) {
            Helpers::setFlash('admin', 'Ürün güncellenemedi. Eksik bilgi mevcut.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/products/' . $id . '/edit'));
        }

        $productModel->update($id, $data);

        $kept = [];
        foreach ($variations as $variation) {
            $codes = $variation['codes'];
            $variationId = isset($variation['id']) ? (int)$variation['id'] : null;
            unset($variation['codes']);
            if ($variationId) {
                $variationModel->update($variationId, $variation);
            } else {
                $variationId = $variationModel->create($id, $variation);
            }
            if (!empty($codes)) {
                $imported = $stockModel->importBulk($variationId, $codes);
                if ($imported) {
                    $variationModel->updateStock($variationId, max($variation['stock'], $imported));
                }
            }
            $kept[] = $variationId;
        }
        $variationModel->deleteMissing($id, $kept);

        Helpers::setFlash('admin', 'Ürün güncellendi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/products'));
    }

    public function destroy(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $productModel = new Product();
        $productModel->delete($id);
        Helpers::setFlash('admin', 'Ürün silindi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/products'));
    }

    public function toggle(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $productModel = new Product();
        $current = $productModel->find($id);
        if ($current) {
            $productModel->setActive($id, !$current['is_active']);
            Helpers::setFlash('admin', 'Ürün durumu güncellendi.', 'success');
        }
        Helpers::redirect(Helpers::baseUrl('admin/products'));
    }

    private function prepareVariations(): array
    {
        $titles = $_POST['variation_title'] ?? [];
        $prices = $_POST['variation_price'] ?? [];
        $oldPrices = $_POST['variation_old_price'] ?? [];
        $stocks = $_POST['variation_stock'] ?? [];
        $skus = $_POST['variation_sku'] ?? [];
        $codes = $_POST['variation_codes'] ?? [];
        $ids = $_POST['variation_id'] ?? [];

        $variations = [];
        foreach ($titles as $index => $title) {
            $title = trim($title);
            if ($title === '') {
                continue;
            }
            $price = isset($prices[$index]) ? (float)str_replace(',', '.', $prices[$index]) : 0;
            if ($price <= 0) {
                continue;
            }
            $codeLines = isset($codes[$index]) ? preg_split('/\r\n|\r|\n/', trim($codes[$index])) : [];
            $codeLines = array_values(array_filter($codeLines, fn($line) => trim($line) !== ''));
            $variations[] = [
                'id' => isset($ids[$index]) ? (int)$ids[$index] : null,
                'title' => $title,
                'price' => $price,
                'old_price' => isset($oldPrices[$index]) && $oldPrices[$index] !== '' ? (float)str_replace(',', '.', $oldPrices[$index]) : null,
                'stock' => isset($stocks[$index]) ? (int)$stocks[$index] : 0,
                'sku' => $skus[$index] ?? null,
                'codes' => $codeLines,
            ];
        }
        return $variations;
    }
}
