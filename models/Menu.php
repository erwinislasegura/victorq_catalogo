<?php
/**
 * Modelo de Menús Dinámicos
 */

class Menu extends Model {
    protected string $table = 'menus';

    public function __construct() {
        parent::__construct();
        if ($this->db) {
            $this->ensurePaymentMenus();
        }
    }

    private function ensurePaymentMenus(): void {
        try {
            $existing = $this->where("module_code = 'payment_gateways' LIMIT 1");
            if (empty($existing)) {
                $sql = "INSERT INTO `menus` (`parent_id`, `title`, `url`, `icon`, `module_code`, `badge`, `badge_class`, `sort_order`, `is_active`) 
                        VALUES (NULL, 'Pasarela Flow.cl', '?c=payment_config', 'bi-credit-card-2-front', 'payment_gateways', 'Flow', 'bg-success', 6, 1)";
                $this->db->exec($sql);
                $menuId = (int)$this->db->lastInsertId();

                // Permisos automáticos para admin y supervisor
                if ($menuId > 0) {
                    $this->db->exec("INSERT IGNORE INTO `role_permissions` (`role_id`, `menu_id`, `can_view`, `can_create`, `can_edit`, `can_delete`) VALUES 
                                     (1, {$menuId}, 1, 1, 1, 1),
                                     (2, {$menuId}, 1, 0, 1, 0),
                                     (3, {$menuId}, 1, 0, 0, 0)");
                }
            }
        } catch (Exception $e) {
            // Silencioso
        }
    }

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
