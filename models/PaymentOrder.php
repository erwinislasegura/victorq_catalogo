<?php
/**
 * Modelo de Órdenes y Transacciones de Pago (Flow.cl)
 * Integrado con el Módulo de Inventario y Kardex
 */

class PaymentOrder extends Model {
    protected string $table = 'payment_orders';

    public function __construct() {
        parent::__construct();
        if ($this->db) {
            $this->checkSchema();
        }
    }

    private function checkSchema(): void {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS `payment_orders` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `commerce_order` VARCHAR(100) NOT NULL UNIQUE,
                `flow_order` VARCHAR(100) NULL,
                `product_id` INT NULL,
                `product_name` VARCHAR(255) NOT NULL,
                `amount` DECIMAL(12, 2) NOT NULL,
                `currency` VARCHAR(10) DEFAULT 'CLP',
                `customer_name` VARCHAR(150) NOT NULL,
                `customer_email` VARCHAR(150) NOT NULL,
                `customer_phone` VARCHAR(50) NULL,
                `status` ENUM('pending', 'paid', 'rejected', 'canceled') DEFAULT 'pending',
                `flow_token` VARCHAR(255) NULL,
                `payment_data` TEXT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `idx_po_commerce` (`commerce_order`),
                INDEX `idx_po_token` (`flow_token`),
                INDEX `idx_po_status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $this->db->exec($sql);
        } catch (Exception $e) {
            // Silencioso
        }
    }

    public function findByCommerceOrder(string $commerceOrder): ?array {
        if (!$this->db) return null;
        $rows = $this->where('commerce_order = :ord LIMIT 1', ['ord' => $commerceOrder]);
        return $rows[0] ?? null;
    }

    public function findByToken(string $token): ?array {
        if (!$this->db) return null;
        $rows = $this->where('flow_token = :tkn LIMIT 1', ['tkn' => $token]);
        return $rows[0] ?? null;
    }

    public function getAllOrders(string $statusFilter = ''): array {
        if (!$this->db) return [];
        if (!empty($statusFilter) && $statusFilter !== 'all') {
            return $this->where('status = :st', ['st' => $statusFilter], 'id DESC');
        }
        return $this->getAll('id DESC');
    }

    /**
     * Marcar orden como pagada y descontar existencias automáticamente en el Kardex de Inventario
     */
    public function markAsPaid(int $orderId, ?array $flowStatusData = null): bool {
        if (!$this->db || $orderId <= 0) return false;

        $order = $this->find($orderId);
        if (!$order) return false;

        // Evitar duplicación si ya estaba marcada como pagada
        if ($order['status'] === 'paid') return true;

        $flowOrderNum = $flowStatusData['flowOrder'] ?? $order['flow_order'] ?? null;
        $paymentDataJson = $flowStatusData ? json_encode($flowStatusData, JSON_UNESCAPED_UNICODE) : $order['payment_data'];

        $updated = $this->update($orderId, [
            'status' => 'paid',
            'flow_order' => $flowOrderNum,
            'payment_data' => $paymentDataJson
        ]);

        if ($updated) {
            $inventoryModel = new Inventory();
            $ref = 'Venta Flow #' . $order['commerce_order'];
            $note = 'Pago confirmado en Flow.cl (Transacción N° ' . ($flowOrderNum ?: $order['commerce_order']) . ')';

            // 1. Si la orden tiene un producto específico
            if (!empty($order['product_id']) && (int)$order['product_id'] > 0) {
                $inventoryModel->registerMovement((int)$order['product_id'], 'sale', 1, $ref, $note);
            }

            // 2. Si la orden contiene múltiples productos guardados en payment_data
            if (!empty($order['payment_data'])) {
                $pData = json_decode($order['payment_data'], true);
                if (!empty($pData['items']) && is_array($pData['items'])) {
                    foreach ($pData['items'] as $item) {
                        $pId = (int)($item['id'] ?? $item['product_id'] ?? 0);
                        $qty = max(1, (int)($item['quantity'] ?? 1));
                        if ($pId > 0) {
                            $inventoryModel->registerMovement($pId, 'sale', $qty, $ref, "Venta multiproducto en carro Flow (Cant: {$qty})");
                        }
                    }
                }
            }
        }

        return $updated;
    }
}
