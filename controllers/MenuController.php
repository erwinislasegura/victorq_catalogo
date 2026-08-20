<?php
/**
 * Controlador de Menús Dinámicos
 */

class MenuController extends Controller {

    public function index(): void {
        Auth::requirePermission('menus', 'view');

        $menuModel = new Menu();
        $menus = $menuModel->getAllWithPermissionsCount();

        $this->render('admin/menus/index', [
            'menus' => $menus
        ]);
    }

    public function create(): void {
        Auth::requirePermission('menus', 'create');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $url = trim($_POST['url'] ?? '');
            $icon = trim($_POST['icon'] ?? 'bi-circle');
            $moduleCode = trim($_POST['module_code'] ?? '');
            $badge = trim($_POST['badge'] ?? '');
            $badgeClass = trim($_POST['badge_class'] ?? 'bg-primary');
            $sortOrder = (int)($_POST['sort_order'] ?? 0);
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            if (empty($title) || empty($url) || empty($moduleCode)) {
                $this->setFlash('error', 'Por favor complete los campos obligatorios.');
                $this->redirect(ADMIN_URL . '/?c=menu');
            }

            $menuModel = new Menu();
            $menuModel->create([
                'title' => $title,
                'url' => $url,
                'icon' => $icon,
                'module_code' => $moduleCode,
                'badge' => !empty($badge) ? $badge : null,
                'badge_class' => $badgeClass,
                'sort_order' => $sortOrder,
                'is_active' => $isActive
            ]);

            $this->setFlash('success', 'Menú creado exitosamente.');
            $this->redirect(ADMIN_URL . '/?c=menu');
        }
    }

    public function edit(): void {
        Auth::requirePermission('menus', 'edit');

        $id = (int)($_POST['id'] ?? 0);
        $menuModel = new Menu();
        $menu = $menuModel->find($id);

        if (!$menu) {
            $this->setFlash('error', 'Menú no encontrado.');
            $this->redirect(ADMIN_URL . '/?c=menu');
        }

        $title = trim($_POST['title'] ?? '');
        $url = trim($_POST['url'] ?? '');
        $icon = trim($_POST['icon'] ?? 'bi-circle');
        $moduleCode = trim($_POST['module_code'] ?? '');
        $badge = trim($_POST['badge'] ?? '');
        $badgeClass = trim($_POST['badge_class'] ?? 'bg-primary');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title) || empty($url) || empty($moduleCode)) {
            $this->setFlash('error', 'Por favor complete los campos obligatorios.');
            $this->redirect(ADMIN_URL . '/?c=menu');
        }

        $menuModel->update($id, [
            'title' => $title,
            'url' => $url,
            'icon' => $icon,
            'module_code' => $moduleCode,
            'badge' => !empty($badge) ? $badge : null,
            'badge_class' => $badgeClass,
            'sort_order' => $sortOrder,
            'is_active' => $isActive
        ]);

        $this->setFlash('success', 'Menú actualizado exitosamente.');
        $this->redirect(ADMIN_URL . '/?c=menu');
    }

    public function delete(): void {
        Auth::requirePermission('menus', 'delete');

        $id = (int)($_GET['id'] ?? 0);
        $menuModel = new Menu();
        $menuModel->delete($id);

        $this->setFlash('success', 'Menú eliminado correctamente.');
        $this->redirect(ADMIN_URL . '/?c=menu');
    }
}
