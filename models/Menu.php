<?php
/**
 * Modelo de Menús Dinámicos
 */

class Menu extends Model {
    protected string $table = 'menus';

    public function getMenusForRole(int $roleId): array {
        if (!$this->db) return [];

        // Si el rol es admin (ID 1), obtiene todos los menús activos
        if ($roleId === 1) {
            $sql = "SELECT * FROM menus WHERE is_active = 1 ORDER BY sort_order ASC";
            return $this->rawQuery($sql);
        }

        // Para otros roles, filtra estrictamente según la tabla de permisos (can_view = 1)
        $sql = "SELECT m.* 
                FROM menus m 
                JOIN role_permissions rp ON m.id = rp.menu_id 
                WHERE rp.role_id = :role_id AND rp.can_view = 1 AND m.is_active = 1 
                ORDER BY m.sort_order ASC";
        return $this->rawQuery($sql, ['role_id' => $roleId]);
    }

    public function getAllWithPermissionsCount(): array {
        if (!$this->db) return [];
        $sql = "SELECT m.*, COUNT(rp.id) as roles_assigned 
                FROM menus m 
                LEFT JOIN role_permissions rp ON m.id = rp.menu_id AND rp.can_view = 1 
                GROUP BY m.id 
                ORDER BY m.sort_order ASC";
        return $this->rawQuery($sql);
    }
}
