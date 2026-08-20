<?php
/**
 * Modelo de Productos
 */

class Product extends Model {
    protected string $table = 'products';

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
}
