<?php
/**
 * Modelo de Permisos de Menús por Rol (RBAC)
 */

class Permission extends Model {
    protected string $table = 'role_permissions';

    public function getPermissionsByRole(int $roleId): array {
        if (!$this->db) return [];
        $sql = "SELECT rp.*, m.title as menu_title, m.module_code, m.icon, m.url 
                FROM menus m 
                LEFT JOIN role_permissions rp ON m.id = rp.menu_id AND rp.role_id = :role_id 
                WHERE m.is_active = 1 
                ORDER BY m.sort_order ASC";
        return $this->rawQuery($sql, ['role_id' => $roleId]);
    }

    public function savePermissions(int $roleId, array $permissionsData): bool {
        if (!$this->db) return false;
        try {
            $this->db->beginTransaction();

            // Eliminar permisos previos del rol
            $stmt = $this->db->prepare("DELETE FROM role_permissions WHERE role_id = :role_id");
            $stmt->execute(['role_id' => $roleId]);

            // Insertar nuevos permisos
            $insertStmt = $this->db->prepare(
                "INSERT INTO role_permissions (role_id, menu_id, can_view, can_create, can_edit, can_delete) 
                 VALUES (:role_id, :menu_id, :can_view, :can_create, :can_edit, :can_delete)"
            );

            foreach ($permissionsData as $menuId => $perms) {
                $canView = !empty($perms['view']) ? 1 : 0;
                $canCreate = !empty($perms['create']) ? 1 : 0;
                $canEdit = !empty($perms['edit']) ? 1 : 0;
                $canDelete = !empty($perms['delete']) ? 1 : 0;

                // Si tiene alguna acción, al menos puede ver
                if ($canCreate || $canEdit || $canDelete) {
                    $canView = 1;
                }

                $insertStmt->execute([
                    'role_id' => $roleId,
                    'menu_id' => $menuId,
                    'can_view' => $canView,
                    'can_create' => $canCreate,
                    'can_edit' => $canEdit,
                    'can_delete' => $canDelete
                ]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Error guardando permisos: " . $e->getMessage());
            return false;
        }
    }
}
