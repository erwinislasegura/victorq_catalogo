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

    public function findBySlug(string $slug): ?array {
        if (!$this->db) return null;
        $rows = $this->where('slug = :slug LIMIT 1', ['slug' => $slug]);
        return $rows[0] ?? null;
    }

    public function findBySlugOrId($identifier): ?array {
        if (!$this->db) return null;
        if (is_numeric($identifier)) {
            return $this->find((int)$identifier);
        }
        return $this->findBySlug((string)$identifier);
    }
}
