<?php
/**
 * Controlador de Tablas Técnicas
 */

class TechnicalTableController extends Controller {

    public function index(): void {
        Auth::requirePermission('tables', 'view');

        $tableModel = new TechnicalTable();
        $tables = $tableModel->getAllWithCategory();

        $categoryModel = new Category();
        $categories = $categoryModel->getAll('sort_order ASC');

        $this->render('admin/tables/index', [
            'tables' => $tables,
            'categories' => $categories
        ]);
    }

    public function create(): void {
        Auth::requirePermission('tables', 'create');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryId = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
            $title = trim($_POST['title'] ?? '');
            $subtitle = trim($_POST['subtitle'] ?? '');
            $headersRaw = trim($_POST['headers_csv'] ?? '');
            $rowsRaw = trim($_POST['rows_csv'] ?? '');
            $note = trim($_POST['note'] ?? '');
            $sortOrder = (int)($_POST['sort_order'] ?? 0);

            $headers = array_filter(array_map('trim', explode(',', $headersRaw)));
            
            $rows = [];
            $rowLines = explode("\n", str_replace("\r", "", $rowsRaw));
            foreach ($rowLines as $line) {
                if (trim($line) !== '') {
                    $rows[] = array_map('trim', explode(',', $line));
                }
            }

            if (empty($title)) {
                $this->setFlash('error', 'El título de la tabla es obligatorio.');
                $this->redirect(ADMIN_URL . '/?c=table');
            }

            $tableModel = new TechnicalTable();
            $tableModel->create([
                'category_id' => $categoryId,
                'title' => $title,
                'subtitle' => $subtitle,
                'headers_json' => json_encode($headers, JSON_UNESCAPED_UNICODE),
                'rows_json' => json_encode($rows, JSON_UNESCAPED_UNICODE),
                'note' => $note,
                'sort_order' => $sortOrder,
                'is_active' => 1
            ]);

            $this->setFlash('success', 'Tabla técnica creada exitosamente.');
            $this->redirect(ADMIN_URL . '/?c=table');
        }
    }

    public function delete(): void {
        Auth::requirePermission('tables', 'delete');

        $id = (int)($_GET['id'] ?? 0);
        $tableModel = new TechnicalTable();
        $tableModel->delete($id);

        $this->setFlash('success', 'Tabla técnica eliminada.');
        $this->redirect(ADMIN_URL . '/?c=table');
    }
}
