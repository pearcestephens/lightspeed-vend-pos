<?php
declare(strict_types=1);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/ProductService.php';
require_once __DIR__ . '/../classes/SalesService.php';

function jsonResponse(array $data, int $status = 200): void {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function handleError(Exception $e): void {
    error_log("API Error: " . $e->getMessage());
    jsonResponse([
        'success' => false,
        'error' => $e->getMessage()
    ], 500);
}

set_exception_handler('handleError');

// Parse route
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';
$path = trim($path, '/');
$segments = explode('/', $path);

$auth = Auth::getInstance();
$productService = new ProductService();
$salesService = new SalesService();

try {
    // Authentication endpoints
    if ($segments[0] === 'auth') {
        if ($segments[1] === 'login' && $method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $result = $auth->login($input['username'] ?? '', $input['password'] ?? '');
            jsonResponse($result);
        }

        if ($segments[1] === 'logout' && $method === 'POST') {
            $auth->logout();
            jsonResponse(['success' => true]);
        }

        if ($segments[1] === 'me' && $method === 'GET') {
            $auth->requireAuth();
            $user = $auth->getCurrentUser();
            jsonResponse(['success' => true, 'user' => $user]);
        }

        jsonResponse(['success' => false, 'error' => 'Unknown auth endpoint'], 404);
    }

    // Product endpoints
    if ($segments[0] === 'products') {
        $auth->requireAuth();

        // GET /products - List products
        if ($method === 'GET' && count($segments) === 1) {
            $filter = new ProductFilter(
                search: $_GET['search'] ?? null,
                categoryId: isset($_GET['category_id']) ? (int)$_GET['category_id'] : null,
                supplierId: isset($_GET['supplier_id']) ? (int)$_GET['supplier_id'] : null,
                isActive: isset($_GET['is_active']) ? (bool)$_GET['is_active'] : true,
                lowStock: isset($_GET['low_stock']) ? (bool)$_GET['low_stock'] : null,
                limit: isset($_GET['limit']) ? (int)$_GET['limit'] : 50,
                offset: isset($_GET['offset']) ? (int)$_GET['offset'] : 0
            );
            $products = $productService->getAll($filter);
            jsonResponse(['success' => true, 'products' => $products]);
        }

        // GET /products/{id} - Get single product
        if ($method === 'GET' && count($segments) === 2) {
            $product = $productService->getById((int)$segments[1]);
            if ($product) {
                jsonResponse(['success' => true, 'product' => $product]);
            }
            jsonResponse(['success' => false, 'error' => 'Product not found'], 404);
        }

        // GET /products/barcode/{barcode} - Lookup by barcode
        if ($method === 'GET' && $segments[1] === 'barcode' && count($segments) === 3) {
            $product = $productService->getByBarcode($segments[2]);
            if ($product) {
                jsonResponse(['success' => true, 'product' => $product]);
            }
            jsonResponse(['success' => false, 'error' => 'Product not found'], 404);
        }

        // POST /products - Create product
        if ($method === 'POST' && count($segments) === 1) {
            $input = json_decode(file_get_contents('php://input'), true);
            $result = $productService->create($input);
            jsonResponse($result, $result['success'] ? 201 : 400);
        }

        // PUT /products/{id} - Update product
        if ($method === 'PUT' && count($segments) === 2) {
            $input = json_decode(file_get_contents('php://input'), true);
            $result = $productService->update((int)$segments[1], $input);
            jsonResponse($result, $result['success'] ? 200 : 400);
        }

        // DELETE /products/{id} - Delete product
        if ($method === 'DELETE' && count($segments) === 2) {
            $result = $productService->delete((int)$segments[1]);
            jsonResponse($result, $result['success'] ? 200 : 400);
        }

        // POST /products/{id}/stock - Adjust stock
        if ($method === 'POST' && $segments[2] === 'stock' && count($segments) === 3) {
            $input = json_decode(file_get_contents('php://input'), true);
            $result = $productService->adjustStock(
                (int)$segments[1],
                (int)($input['quantity'] ?? 0),
                $input['reason'] ?? 'Manual adjustment',
                isset($input['location_id']) ? (int)$input['location_id'] : null
            );
            jsonResponse($result, $result['success'] ? 200 : 400);
        }

        jsonResponse(['success' => false, 'error' => 'Unknown product endpoint'], 404);
    }

    // Sales endpoints
    if ($segments[0] === 'sales') {
        $auth->requireAuth();

        // POST /sales - Create sale
        if ($method === 'POST' && count($segments) === 1) {
            $input = json_decode(file_get_contents('php://input'), true);
            $result = $salesService->createSale($input);
            jsonResponse($result, $result['success'] ? 201 : 400);
        }

        // GET /sales/{id} - Get sale details
        if ($method === 'GET' && count($segments) === 2) {
            $sale = $salesService->getSale((int)$segments[1]);
            if ($sale) {
                jsonResponse(['success' => true, 'sale' => $sale]);
            }
            jsonResponse(['success' => false, 'error' => 'Sale not found'], 404);
        }

        // GET /sales - Get recent sales
        if ($method === 'GET' && count($segments) === 1) {
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
            $sales = $salesService->getRecentSales($limit);
            jsonResponse(['success' => true, 'sales' => $sales]);
        }

        jsonResponse(['success' => false, 'error' => 'Unknown sales endpoint'], 404);
    }

    // Dashboard stats
    if ($segments[0] === 'dashboard' && $method === 'GET') {
        $auth->requireAuth();
        
        $todaySales = $salesService->getRecentSales(100);
        $todayTotal = array_sum(array_column($todaySales, 'total_amount'));
        $lowStock = $productService->getLowStockProducts();
        
        jsonResponse([
            'success' => true,
            'stats' => [
                'today_sales' => count($todaySales),
                'today_revenue' => $todayTotal,
                'low_stock_count' => count($lowStock),
                'recent_sales' => array_slice($todaySales, 0, 10)
            ]
        ]);
    }

    jsonResponse(['success' => false, 'error' => 'Endpoint not found'], 404);

} catch (Exception $e) {
    handleError($e);
}
