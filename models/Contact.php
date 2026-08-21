<?php
/**
 * Modelo de Mensajes de Contacto (Página de Contacto Web)
 */

class Contact extends Model {
    protected string $table = 'contacts';

    public function __construct() {
        parent::__construct();
        if ($this->db) {
            $this->checkSchema();
            $this->ensureMenu();
        }
    }

    private function checkSchema(): void {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS `contacts` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(150) NOT NULL,
                `company` VARCHAR(150) NOT NULL,
                `rut` VARCHAR(50) NULL,
                `email` VARCHAR(150) NOT NULL,
                `phone` VARCHAR(50) NOT NULL,
                `subject` VARCHAR(150) NOT NULL,
                `message` TEXT NOT NULL,
                `status` ENUM('unread', 'read', 'responded', 'archived') DEFAULT 'unread',
                `admin_notes` TEXT NULL,
                `ip_address` VARCHAR(45) NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX `idx_contact_status` (`status`),
                INDEX `idx_contact_created` (`created_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $this->db->exec($sql);
        } catch (Exception $e) {
            // Silencioso
        }
    }

    private function ensureMenu(): void {
        try {
            $existing = $this->db->query("SELECT id FROM menus WHERE module_code = 'contacts' LIMIT 1")->fetch();
            if (empty($existing)) {
                $sql = "INSERT INTO `menus` (`parent_id`, `title`, `url`, `icon`, `module_code`, `badge`, `badge_class`, `sort_order`, `is_active`) 
                        VALUES (NULL, 'Mensajes de Contacto', '?c=contact', 'bi-envelope-paper', 'contacts', 'Nuevo', 'bg-info', 5, 1)";
                $this->db->exec($sql);
                $menuId = (int)$this->db->lastInsertId();

                if ($menuId > 0) {
                    $this->db->exec("INSERT IGNORE INTO `role_permissions` (`role_id`, `menu_id`, `can_view`, `can_create`, `can_edit`, `can_delete`) VALUES 
                                     (1, {$menuId}, 1, 1, 1, 1),
                                     (2, {$menuId}, 1, 0, 1, 0),
                                     (3, {$menuId}, 1, 1, 1, 0)");
                }
            }
        } catch (Exception $e) {
            // Silencioso
        }
    }

    public function getAllOrdered(string $statusFilter = ''): array {
        if (!$this->db) return [];
        if (!empty($statusFilter) && $statusFilter !== 'all') {
            return $this->where('status = :st', ['st' => $statusFilter], 'created_at DESC');
        }
        return $this->getAll('created_at DESC');
    }

    public function getCountsByStatus(): array {
        if (!$this->db) return ['unread' => 0, 'read' => 0, 'responded' => 0, 'archived' => 0, 'total' => 0];
        $sql = "SELECT status, COUNT(*) as count FROM contacts GROUP BY status";
        $rows = $this->rawQuery($sql);
        
        $res = ['unread' => 0, 'read' => 0, 'responded' => 0, 'archived' => 0, 'total' => 0];
        foreach ($rows as $r) {
            $res[$r['status']] = (int)$r['count'];
            $res['total'] += (int)$r['count'];
        }
        return $res;
    }
}
