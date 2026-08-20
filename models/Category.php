<?php
/**
 * Modelo de Categorías
 */

class Category extends Model {
    protected string $table = 'categories';

    public function getAllWithProductCount(): array {
        if (!$this->db) return [];
        $sql = "SELECT c.*, COUNT(p.id) as product_count 
                FROM categories c 
                LEFT JOIN products p ON c.id = p.category_id AND p.is_active = 1 
                GROUP BY c.id 
                ORDER BY c.sort_order ASC";
        return $this->rawQuery($sql);
    }

    public function getActiveCategories(): array {
        return $this->where('is_active = 1', [], 'sort_order ASC');
    }
}
