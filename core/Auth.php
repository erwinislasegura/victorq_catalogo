<?php
/**
 * Helper de Autenticación, Sesión y Verificación de Permisos (RBAC)
 */

class Auth {
    public static function check(): bool {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    public static function user(): ?array {
        if (!self::check()) return null;
        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'] ?? 'Usuario',
            'email' => $_SESSION['user_email'] ?? '',
            'role_id' => $_SESSION['user_role_id'] ?? 0,
            'role_name' => $_SESSION['user_role_name'] ?? 'Sin Rol',
            'role_slug' => $_SESSION['user_role_slug'] ?? '',
            'avatar' => $_SESSION['user_avatar'] ?? null,
            'phone' => $_SESSION['user_phone'] ?? '',
        ];
    }

    public static function id(): int {
        return (int)($_SESSION['user_id'] ?? 0);
    }

    public static function roleSlug(): string {
        return $_SESSION['user_role_slug'] ?? '';
    }

    public static function roleName(): string {
        return $_SESSION['user_role_name'] ?? '';
    }

    public static function isAdmin(): bool {
        return self::roleSlug() === 'admin';
    }

    public static function login(array $user): void {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role_id'] = $user['role_id'];
        $_SESSION['user_role_name'] = $user['role_name'] ?? 'Usuario';
        $_SESSION['user_role_slug'] = $user['role_slug'] ?? 'user';
        $_SESSION['user_avatar'] = $user['avatar'] ?? null;
        $_SESSION['user_phone'] = $user['phone'] ?? '';
        
        // Cargar matriz de permisos del rol en la sesión
        self::loadPermissions($user['role_id']);
        
        // Actualizar último login en base de datos
        $db = Database::getConnection();
        if ($db) {
            $stmt = $db->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
            $stmt->execute(['id' => $user['id']]);
        }
    }

    public static function loadPermissions(int $roleId): void {
        $db = Database::getConnection();
        if (!$db) {
            $_SESSION['permissions'] = [];
            return;
        }
        
        $sql = "SELECT m.module_code, rp.can_view, rp.can_create, rp.can_edit, rp.can_delete 
                FROM role_permissions rp 
                JOIN menus m ON rp.menu_id = m.id 
                WHERE rp.role_id = :role_id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['role_id' => $roleId]);
        $rows = $stmt->fetchAll();
        
        $perms = [];
        foreach ($rows as $r) {
            $perms[$r['module_code']] = [
                'view' => (bool)$r['can_view'],
                'create' => (bool)$r['can_create'],
                'edit' => (bool)$r['can_edit'],
                'delete' => (bool)$r['can_delete'],
            ];
        }
        $_SESSION['permissions'] = $perms;
    }

    public static function can(string $module, string $action = 'view'): bool {
        // El Administrador tiene acceso total a todos los módulos y acciones
        if (self::isAdmin()) return true;
        
        $perms = $_SESSION['permissions'] ?? [];
        if (!isset($perms[$module])) return false;
        
        return !empty($perms[$module][$action]);
    }

    public static function requireAuth(): void {
        if (!self::check()) {
            $_SESSION['flash_error'] = 'Debe iniciar sesión para acceder al panel de control.';
            header('Location: ' . ADMIN_URL . '/?c=auth&a=login');
            exit;
        }
    }

    public static function requirePermission(string $module, string $action = 'view'): void {
        self::requireAuth();
        if (!self::can($module, $action)) {
            header('Location: ' . ADMIN_URL . '/?c=dashboard&a=forbidden');
            exit;
        }
    }

    public static function logout(): void {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}
