<?php
/**
 * Modelo de Inventario, Control de Existencias y Kardex Industrial
 */

class Inventory extends Model {
    protected string $table = 'inventory_movements';

    public function __construct() {
        parent::__construct();
        if ($this->db) {
            $this->checkSchema();
            $this->ensureMenu();
        }
    }

    private function checkSchema(): void {
        try {
            // 1. Asegurar columnas de inventario en la tabla products
            $productCols = [
                'stock' => "ALTER TABLE `products` ADD COLUMN `stock` INT DEFAULT 10 AFTER `price`",
                'min_stock' => "ALTER TABLE `products` ADD COLUMN `min_stock` INT DEFAULT 2 AFTER `stock`",
                'sku' => "ALTER TABLE `products` ADD COLUMN `sku` VARCHAR(50) NULL AFTER `model`",
                'warehouse_location' => "ALTER TABLE `products` ADD COLUMN `warehouse_location` VARCHAR(100) DEFAULT 'Bodega Central - Santiago' AFTER `min_stock`"
            ];

            foreach ($productCols as $colName => $sql) {
                $check = $this->db->query("SHOW COLUMNS FROM `products` LIKE '{$colName}'")->fetch();
                if (!$check) {
                    $this->db->exec($sql);
                }
            }

            // 2. Asegurar tabla de movimientos de inventario (Kardex)
            $sqlKardex = "CREATE TABLE IF NOT EXISTS `inventory_movements` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `product_id` INT NOT NULL,
                `type` ENUM('in', 'out', 'adjustment', 'sale') NOT NULL,
                `quantity` INT NOT NULL,
                `previous_stock` INT NOT NULL,
                `new_stock` INT NOT NULL,
                `reference` VARCHAR(150) NULL,
                `notes` TEXT NULL,
                `user_id` INT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX `idx_im_product` (`product_id`),
                INDEX `idx_im_type` (`type`),
                INDEX `idx_im_created` (`created_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $this->db->exec($sqlKardex);
        } catch (Exception $e) {
            // Silencioso
        }
    }

    private function ensureMenu(): void {
        try {
            $existing = $this->db->query("SELECT id FROM menus WHERE module_code = 'inventory' LIMIT 1")->fetch();
            if (empty($existing)) {
                $sql = "INSERT INTO `menus` (`parent_id`, `title`, `url`, `icon`, `module_code`, `badge`, `badge_class`, `sort_order`, `is_active`) 
                        VALUES (NULL, 'Inventario & Kardex', '?c=inventory', 'bi-boxes', 'inventory', 'Stock', 'bg-primary', 4, 1)";
                $this->db->exec($sql);
                $menuId = (int)$this->db->lastInsertId();

                if ($menuId > 0) {
                    $this->db->exec("INSERT IGNORE INTO `role_permissions` (`role_id`, `menu_id`, `can_view`, `can_create`, `can_edit`, `can_delete`) VALUES 
                                     (1, {$menuId}, 1, 1, 1, 1),
                                     (2, {$menuId}, 1, 1, 1, 0),
                                     (3, {$menuId}, 1, 0, 0, 0)");
                }
            }
        } catch (Exception $e) {
            // Silencioso
        }
    }

    /**
     * Obtener listado de inventario con estado de semáforo
     */
    public function getStockOverview(string $filter = ''): array {
        if (!$this->db) return [];
        $where = "WHERE p.is_active = 1";
        if ($filter === 'critical') {
            $where .= " AND p.stock > 0 AND p.stock <= p.min_stock";
        } elseif ($filter === 'out_of_stock') {
            $where .= " AND p.stock <= 0";
        } elseif ($filter === 'optimal') {
            $where .= " AND p.stock > p.min_stock";
        }

        $sql = "SELECT p.id, p.model, p.sku, p.name, p.image, p.price, p.stock, p.min_stock, p.warehouse_location,
                       c.name as category_name, c.slug as category_slug,
                       (p.stock * p.price) as total_valuation,
                       CASE 
                           WHEN p.stock <= 0 THEN 'out_of_stock'
                           WHEN p.stock <= p.min_stock THEN 'critical'
                           ELSE 'optimal'
                       END as stock_status
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                {$where}
                ORDER BY p.stock ASC, p.name ASC";
        return $this->rawQuery($sql);
    }

    /**
     * Obtener métricas KPI del inventario
     */
    public function getKpiMetrics(): array {
        if (!$this->db) {
            return [
                'total_units' => 0,
                'total_valuation' => 0,
                'critical_count' => 0,
                'out_of_stock_count' => 0,
                'optimal_count' => 0,
                'total_products' => 0,
                'month_movements' => 0
            ];
        }

        $sql = "SELECT 
                    COUNT(*) as total_products,
                    COALESCE(SUM(stock), 0) as total_units,
                    COALESCE(SUM(stock * price), 0) as total_valuation,
                    COALESCE(SUM(CASE WHEN stock <= 0 THEN 1 ELSE 0 END), 0) as out_of_stock_count,
                    COALESCE(SUM(CASE WHEN stock > 0 AND stock <= min_stock THEN 1 ELSE 0 END), 0) as critical_count,
                    COALESCE(SUM(CASE WHEN stock > min_stock THEN 1 ELSE 0 END), 0) as optimal_count
                FROM products WHERE is_active = 1";
        $stats = $this->db->query($sql)->fetch() ?: [];

        $sqlMov = "SELECT COUNT(*) as cnt FROM inventory_movements WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $movStats = $this->db->query($sqlMov)->fetch() ?: ['cnt' => 0];

        return [
            'total_units' => (int)($stats['total_units'] ?? 0),
            'total_valuation' => (float)($stats['total_valuation'] ?? 0),
            'critical_count' => (int)($stats['critical_count'] ?? 0),
            'out_of_stock_count' => (int)($stats['out_of_stock_count'] ?? 0),
            'optimal_count' => (int)($stats['optimal_count'] ?? 0),
            'total_products' => (int)($stats['total_products'] ?? 0),
            'month_movements' => (int)($movStats['cnt'] ?? 0)
        ];
    }

    /**
     * Registrar movimiento en Kardex y actualizar stock del producto
     */
    public function registerMovement(int $productId, string $type, int $qty, string $ref = '', string $notes = '', ?int $userId = null): bool {
        if (!$this->db || $productId <= 0) return false;

        try {
            $this->db->beginTransaction();

            $pStmt = $this->db->prepare("SELECT stock FROM products WHERE id = :id FOR UPDATE");
            $pStmt->execute(['id' => $productId]);
            $p = $pStmt->fetch();

            if (!$p) {
                $this->db->rollBack();
                return false;
            }

            $prevStock = (int)$p['stock'];
            $newStock = $prevStock;

            if ($type === 'in') {
                $newStock = $prevStock + $qty;
            } elseif ($type === 'out' || $type === 'sale') {
                $newStock = max(0, $prevStock - $qty);
            } elseif ($type === 'adjustment') {
                $newStock = max(0, $qty);
                $qty = abs($newStock - $prevStock);
            }

            // 1. Actualizar producto
            $uStmt = $this->db->prepare("UPDATE products SET stock = :st WHERE id = :id");
            $uStmt->execute(['st' => $newStock, 'id' => $productId]);

            // 2. Registrar en Kardex
            $kStmt = $this->db->prepare("INSERT INTO inventory_movements 
                (product_id, type, quantity, previous_stock, new_stock, reference, notes, user_id, created_at) 
                VALUES (:p_id, :type, :qty, :prev_st, :new_st, :ref, :notes, :u_id, NOW())");
            $kStmt->execute([
                'p_id' => $productId,
                'type' => $type,
                'qty' => $qty,
                'prev_st' => $prevStock,
                'new_st' => $newStock,
                'ref' => $ref,
                'notes' => $notes,
                'u_id' => $userId ?? (Auth::user()['id'] ?? null)
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
    }

    /**
     * Obtener movimientos de Kardex con nombres y datos de producto
     */
    public function getKardex(array $filters = [], int $limit = 100): array {
        if (!$this->db) return [];

        $where = "WHERE 1=1";
        $params = [];

        if (!empty($filters['product_id'])) {
            $where .= " AND im.product_id = :p_id";
            $params['p_id'] = (int)$filters['product_id'];
        }
        if (!empty($filters['type'])) {
            $where .= " AND im.type = :type";
            $params['type'] = $filters['type'];
        }

        $sql = "SELECT im.*, p.name as product_name, p.model as product_model, p.image as product_image, p.price as product_price,
                       u.name as user_name
                FROM inventory_movements im
                LEFT JOIN products p ON im.product_id = p.id
                LEFT JOIN users u ON im.user_id = u.id
                {$where}
                ORDER BY im.created_at DESC, im.id DESC
                LIMIT {$limit}";

        return $this->rawQuery($sql, $params);
    }
}
