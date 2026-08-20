<?php
/**
 * Controlador de Categorías
 */

class CategoryController extends Controller {

    public function index(): void {
        Auth::requirePermission('categories', 'view');

        $categoryModel = new Category();
        $categories = $categoryModel->getAllWithProductCount();

        $this->render('admin/categories/index', [
            'categories' => $categories
        ]);
    }

    public function create(): void {
        Auth::requirePermission('categories', 'create');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $icon = trim($_POST['icon'] ?? 'bi-tag');
            $sortOrder = (int)($_POST['sort_order'] ?? 0);
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            if (empty($slug)) {
                $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
            }

            if (empty($name) || empty($slug)) {
                $this->setFlash('error', 'El nombre y el slug son obligatorios.');
                $this->redirect(ADMIN_URL . '/?c=category');
            }

            $categoryModel = new Category();
            $categoryModel->create([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'icon' => $icon,
                'sort_order' => $sortOrder,
                'is_active' => $isActive
            ]);

            $this->setFlash('success', 'Categoría creada exitosamente.');
            $this->redirect(ADMIN_URL . '/?c=category');
        }
    }

    public function edit(): void {
        Auth::requirePermission('categories', 'edit');

        $id = (int)($_POST['id'] ?? 0);
        $categoryModel = new Category();
        $category = $categoryModel->find($id);

        if (!$category) {
            $this->setFlash('error', 'Categoría no encontrada.');
            $this->redirect(ADMIN_URL . '/?c=category');
        }

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $icon = trim($_POST['icon'] ?? 'bi-tag');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name) || empty($slug)) {
            $this->setFlash('error', 'El nombre y el slug son obligatorios.');
            $this->redirect(ADMIN_URL . '/?c=category');
        }

        $categoryModel->update($id, [
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'icon' => $icon,
            'sort_order' => $sortOrder,
            'is_active' => $isActive
        ]);

        $this->setFlash('success', 'Categoría actualizada exitosamente.');
        $this->redirect(ADMIN_URL . '/?c=category');
    }

    public function delete(): void {
        Auth::requirePermission('categories', 'delete');

        $id = (int)($_GET['id'] ?? 0);
        $categoryModel = new Category();
        $category = $categoryModel->find($id);

        if ($category) {
            // Verificar si tiene productos asignados
            $productModel = new Product();
            $count = $productModel->count('category_id = :cat_id', ['cat_id' => $id]);
            
            if ($count > 0) {
                $this->setFlash('error', "No se puede eliminar la categoría porque contiene {$count} productos.");
            } else {
                $categoryModel->delete($id);
                $this->setFlash('success', 'Categoría eliminada correctamente.');
            }
        }

        $this->redirect(ADMIN_URL . '/?c=category');
    }
}
