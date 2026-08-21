<?php
/**
 * Modelo de Productos
 */

class Product extends Model {
    protected string $table = 'products';

    public function __construct() {
        parent::__construct();
        if ($this->db) {
            try {
                $cols = $this->db->query("SHOW COLUMNS FROM products LIKE 'datasheet_pdf'")->fetchAll();
                if (empty($cols)) {
                    $this->db->exec("ALTER TABLE products ADD COLUMN datasheet_pdf VARCHAR(255) NULL AFTER image");
                }
                $colsPrice = $this->db->query("SHOW COLUMNS FROM products LIKE 'price'")->fetchAll();
                if (empty($colsPrice)) {
                    $this->db->exec("ALTER TABLE products ADD COLUMN price DECIMAL(12,2) DEFAULT 150000.00 AFTER description");
                }
            } catch (Exception $e) {
                // Silencioso si la tabla no existe durante arranque inicial
            }
        }
    }

    public function getAllWithCategory(string $orderBy = 'p.sort_order ASC, p.id ASC'): array {
        if (!$this->db) return [];
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY {$orderBy}";
        return $this->rawQuery($sql);
    }

    public function findWithCategory(int $id): ?array {
        if (!$this->db) return null;
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id LIMIT 1";
        $rows = $this->rawQuery($sql, ['id' => $id]);
        return $rows[0] ?? null;
    }

    public function findBySlugOrId($identifier): ?array {
        if (!$this->db) return null;
        if (is_numeric($identifier)) {
            return $this->findWithCategory((int)$identifier);
        }
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.model = :slug OR p.name LIKE :nameslug LIMIT 1";
        $rows = $this->rawQuery($sql, ['slug' => $identifier, 'nameslug' => '%' . $identifier . '%']);
        return $rows[0] ?? null;
    }

    public function getActiveByCategory(string $categorySlug = ''): array {
        if (!$this->db) return [];
        if (!empty($categorySlug) && $categorySlug !== 'todos') {
            $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                    FROM products p 
                    JOIN categories c ON p.category_id = c.id 
                    WHERE p.is_active = 1 AND c.slug = :slug 
                    ORDER BY p.sort_order ASC";
            return $this->rawQuery($sql, ['slug' => $categorySlug]);
        }
        
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.is_active = 1 
                ORDER BY p.sort_order ASC";
        return $this->rawQuery($sql);
    }

    public function getRelatedProducts(int $categoryId, int $excludeProductId, int $limit = 4): array {
        if (!$this->db) return [];
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.is_active = 1 AND p.category_id = :cat_id AND p.id != :exc_id 
                ORDER BY p.sort_order ASC, p.id ASC 
                LIMIT {$limit}";
        $rows = $this->rawQuery($sql, ['cat_id' => $categoryId, 'exc_id' => $excludeProductId]);
        
        // If not enough in same category, fetch other featured active products
        if (count($rows) < $limit) {
            $needed = $limit - count($rows);
            $moreSql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                        FROM products p 
                        JOIN categories c ON p.category_id = c.id 
                        WHERE p.is_active = 1 AND p.id != :exc_id AND p.category_id != :cat_id 
                        ORDER BY p.is_featured DESC, p.sort_order ASC 
                        LIMIT {$needed}";
            $moreRows = $this->rawQuery($moreSql, ['exc_id' => $excludeProductId, 'cat_id' => $categoryId]);
            $rows = array_merge($rows, $moreRows);
        }
        return $rows;
    }
}
