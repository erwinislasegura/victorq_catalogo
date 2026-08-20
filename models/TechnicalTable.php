<?php
/**
 * Modelo de Tablas Técnicas de Ingeniería
 */

class TechnicalTable extends Model {
    protected string $table = 'technical_tables';

    public function getAllWithCategory(): array {
        if (!$this->db) return [];
        $sql = "SELECT t.*, c.name as category_name 
                FROM technical_tables t 
                LEFT JOIN categories c ON t.category_id = c.id 
                ORDER BY t.sort_order ASC, t.id ASC";
        return $this->rawQuery($sql);
    }
}
