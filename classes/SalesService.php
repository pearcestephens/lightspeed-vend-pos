<?php
declare(strict_types=1);

class SalesService {
    private Database $db;
    private Auth $auth;
    private ProductService $productService;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->auth = Auth::getInstance();
        $this->productService = new ProductService();
    }

    public function createSale(array $data): array {
        $this->auth->requireAuth();

        try {
            $this->db->beginTransaction();

            $user = $this->auth->getCurrentUser();

            // Validate items
            if (empty($data['items']) || !is_array($data['items'])) {
                throw new Exception("No items in cart");
            }

            // Create sale record
            $this->db->execute(
                "INSERT INTO sales (location_id, register_id, staff_id, customer_id, subtotal, tax_amount, total_amount, status)
                 VALUES (?, ?, ?, ?, ?, ?, ?, 'completed')",
                [
                    $user['location_id'],
                    $data['register_id'] ?? null,
                    $user['id'],
                    $data['customer_id'] ?? null,
                    $data['subtotal'] ?? 0,
                    $data['tax_amount'] ?? 0,
                    $data['total_amount'] ?? 0
                ]
            );

            $saleId = $this->db->lastInsertId();

            // Add sale items
            foreach ($data['items'] as $item) {
                $product = $this->productService->getById($item['product_id']);
                if (!$product) {
                    throw new Exception("Product {$item['product_id']} not found");
                }

                $this->db->execute(
                    "INSERT INTO sale_items (sale_id, product_id, quantity, unit_price, discount_amount, tax_amount, line_total)
                     VALUES (?, ?, ?, ?, ?, ?, ?)",
                    [
                        $saleId,
                        $item['product_id'],
                        $item['quantity'],
                        $item['unit_price'] ?? $product['sell_price'],
                        $item['discount_amount'] ?? 0,
                        $item['tax_amount'] ?? 0,
                        $item['line_total'] ?? 0
                    ]
                );

                // Update inventory
                if ($product['track_inventory']) {
                    $this->productService->adjustStock(
                        $item['product_id'],
                        -$item['quantity'],
                        "Sale #{$saleId}",
                        $user['location_id']
                    );
                }
            }

            // Record payment
            if (!empty($data['payments']) && is_array($data['payments'])) {
                foreach ($data['payments'] as $payment) {
                    $this->db->execute(
                        "INSERT INTO payments (sale_id, payment_method, amount, status)
                         VALUES (?, ?, ?, 'completed')",
                        [
                            $saleId,
                            $payment['method'] ?? 'cash',
                            $payment['amount'] ?? 0
                        ]
                    );
                }
            }

            $this->db->commit();

            return ['success' => true, 'sale_id' => $saleId];

        } catch (Exception $e) {
            $this->db->rollback();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getSale(int $id): ?array {
        $sale = $this->db->fetchOne(
            "SELECT s.*, st.name as staff_name, c.name as customer_name
             FROM sales s
             LEFT JOIN staff st ON s.staff_id = st.id
             LEFT JOIN customers c ON s.customer_id = c.id
             WHERE s.id = ?",
            [$id]
        );

        if ($sale) {
            $sale['items'] = $this->db->fetchAll(
                "SELECT si.*, p.name as product_name
                 FROM sale_items si
                 JOIN products p ON si.product_id = p.id
                 WHERE si.sale_id = ?",
                [$id]
            );

            $sale['payments'] = $this->db->fetchAll(
                "SELECT * FROM payments WHERE sale_id = ?",
                [$id]
            );
        }

        return $sale;
    }

    public function getRecentSales(int $limit = 20): array {
        return $this->db->fetchAll(
            "SELECT s.*, st.name as staff_name, c.name as customer_name
             FROM sales s
             LEFT JOIN staff st ON s.staff_id = st.id
             LEFT JOIN customers c ON s.customer_id = c.id
             ORDER BY s.created_at DESC
             LIMIT ?",
            [$limit]
        );
    }
}
