<?php
/**
 * Controlador de Roles y Matriz de Permisos (RBAC)
 */

class RoleController extends Controller {

    public function index(): void {
        Auth::requirePermission('roles', 'view');

        $roleModel = new Role();
        $roles = $roleModel->getAllWithUserCount();

        $this->render('admin/roles/index', [
            'roles' => $roles
        ]);
    }

    public function create(): void {
        Auth::requirePermission('roles', 'create');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($slug)) {
                $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
            }

            if (empty($name) || empty($slug)) {
                $this->setFlash('error', 'El nombre y el slug del rol son obligatorios.');
                $this->redirect(ADMIN_URL . '/?c=role');
            }

            $roleModel = new Role();
            $newRoleId = $roleModel->create([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'is_system' => 0
            ]);

            $this->setFlash('success', 'Rol creado exitosamente. Ahora configure sus permisos.');
            $this->redirect(ADMIN_URL . '/?c=role&a=permissions&id=' . $newRoleId);
        }
    }

    public function edit(): void {
        Auth::requirePermission('roles', 'edit');

        $id = (int)($_POST['id'] ?? 0);
        $roleModel = new Role();
        $role = $roleModel->find($id);

        if (!$role) {
            $this->setFlash('error', 'Rol no encontrado.');
            $this->redirect(ADMIN_URL . '/?c=role');
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        $roleModel->update($id, [
            'name' => $name,
            'description' => $description
        ]);

        $this->setFlash('success', 'Rol actualizado exitosamente.');
        $this->redirect(ADMIN_URL . '/?c=role');
    }

    public function permissions(): void {
        Auth::requirePermission('roles', 'edit');

        $roleId = (int)($_GET['id'] ?? 0);
        $roleModel = new Role();
        $role = $roleModel->find($roleId);

        if (!$role) {
            $this->setFlash('error', 'Rol no encontrado.');
            $this->redirect(ADMIN_URL . '/?c=role');
        }

        $permissionModel = new Permission();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $permissionsData = $_POST['perm'] ?? [];
            $permissionModel->savePermissions($roleId, $permissionsData);

            // Si el rol modificado es el del usuario actual, recargar permisos en sesión
            if (Auth::user()['role_id'] === $roleId) {
                Auth::loadPermissions($roleId);
            }

            $this->setFlash('success', 'Permisos del rol actualizados exitosamente.');
            $this->redirect(ADMIN_URL . '/?c=role&a=permissions&id=' . $roleId);
        }

        $menuModel = new Menu();
        $menus = $menuModel->getAll('sort_order ASC');
        $currentPermissions = $permissionModel->where('role_id = :role_id', ['role_id' => $roleId]);

        // Mapear permisos por menu_id para acceso directo en la vista
        $permMap = [];
        foreach ($currentPermissions as $p) {
            $permMap[$p['menu_id']] = $p;
        }

        $this->render('admin/roles/permissions', [
            'role' => $role,
            'menus' => $menus,
            'permMap' => $permMap
        ]);
    }

    public function delete(): void {
        Auth::requirePermission('roles', 'delete');

        $id = (int)($_GET['id'] ?? 0);
        $roleModel = new Role();
        $role = $roleModel->find($id);

        if ($role) {
            if ($role['is_system'] || $role['id'] === 1) {
                $this->setFlash('error', 'No se pueden eliminar los roles del sistema.');
                $this->redirect(ADMIN_URL . '/?c=role');
            }

            $userModel = new User();
            $count = $userModel->count('role_id = :role_id', ['role_id' => $id]);
            if ($count > 0) {
                $this->setFlash('error', "No se puede eliminar el rol porque tiene {$count} usuarios asignados.");
                $this->redirect(ADMIN_URL . '/?c=role');
            }

            $roleModel->delete($id);
            $this->setFlash('success', 'Rol eliminado exitosamente.');
        }

        $this->redirect(ADMIN_URL . '/?c=role');
    }
}
