<?php
/**
 * Modelo de Roles
 */

class Role extends Model {
    protected string $table = 'roles';

    public function getAllWithUserCount(): array {
        if (!$this->db) return [];
        $sql = "SELECT r.*, COUNT(u.id) as user_count 
                FROM roles r 
                LEFT JOIN users u ON r.id = u.role_id 
                GROUP BY r.id 
                ORDER BY r.id ASC";
        return $this->rawQuery($sql);
    }
}
