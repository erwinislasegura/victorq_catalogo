<?php
/**
 * Modelo de Solicitudes y Emisión de Cotizaciones
 */

class Quote extends Model {
    protected string $table = 'quotes';

    public function __construct() {
        parent::__construct();
        if ($this->db) {
            $this->checkSchema();
        }
    }

    private function checkSchema(): void {
        try {
            // Verificar y agregar columnas para cotizaciones multiproducto y descuentos
            $cols = [
                'items_json' => "ALTER TABLE `quotes` ADD COLUMN `items_json` LONGTEXT NULL AFTER `product_interest`",
                'discount_percent' => "ALTER TABLE `quotes` ADD COLUMN `discount_percent` DECIMAL(5,2) DEFAULT 0.00 AFTER `items_json`",
                'discount_amount' => "ALTER TABLE `quotes` ADD COLUMN `discount_amount` DECIMAL(12,2) DEFAULT 0.00 AFTER `discount_percent`",
                'subtotal_neto' => "ALTER TABLE `quotes` ADD COLUMN `subtotal_neto` DECIMAL(12,2) DEFAULT 0.00 AFTER `discount_amount`",
                'iva_amount' => "ALTER TABLE `quotes` ADD COLUMN `iva_amount` DECIMAL(12,2) DEFAULT 0.00 AFTER `subtotal_neto`",
                'total_amount' => "ALTER TABLE `quotes` ADD COLUMN `total_amount` DECIMAL(12,2) DEFAULT 0.00 AFTER `iva_amount`"
            ];

            foreach ($cols as $colName => $alterSql) {
                $check = $this->db->query("SHOW COLUMNS FROM `quotes` LIKE '{$colName}'")->fetch();
                if (!$check) {
                    $this->db->exec($alterSql);
                }
            }
        } catch (Exception $e) {
            // Silencioso
        }
    }

    public function getAllWithProduct(): array {
        if (!$this->db) return [];
        $sql = "SELECT q.*, p.name as product_name, p.model as product_model, p.image as product_image, p.price as product_price 
                FROM quotes q 
                LEFT JOIN products p ON q.product_id = p.id 
                ORDER BY q.created_at DESC";
        return $this->rawQuery($sql);
    }

    public function findWithProduct(int $id): ?array {
        if (!$this->db) return null;
        $sql = "SELECT q.*, p.name as product_name, p.model as product_model, p.image as product_image, p.price as product_price, p.specs_json, p.datasheet_pdf 
                FROM quotes q 
                LEFT JOIN products p ON q.product_id = p.id 
                WHERE q.id = :id LIMIT 1";
        $rows = $this->rawQuery($sql, ['id' => $id]);
        return $rows[0] ?? null;
    }

    public function getLatest(int $limit = 5): array {
        if (!$this->db) return [];
        $sql = "SELECT q.*, p.name as product_name, p.model as product_model 
                FROM quotes q 
                LEFT JOIN products p ON q.product_id = p.id 
                ORDER BY q.created_at DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCountsByStatus(): array {
        if (!$this->db) return ['pending' => 0, 'in_review' => 0, 'quoted' => 0, 'closed' => 0, 'total' => 0];
        $sql = "SELECT status, COUNT(*) as count FROM quotes GROUP BY status";
        $rows = $this->rawQuery($sql);
        
        $res = ['pending' => 0, 'in_review' => 0, 'quoted' => 0, 'closed' => 0, 'total' => 0];
        foreach ($rows as $r) {
            $res[$r['status']] = (int)$r['count'];
            $res['total'] += (int)$r['count'];
        }
        return $res;
    }
}
