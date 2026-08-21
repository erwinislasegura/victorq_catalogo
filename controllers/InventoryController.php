<?php
/**
 * Controlador de Inventario, Control de Existencias y Kardex Industrial
 */

class InventoryController extends Controller {

    public function index(): void {
        Auth::requirePermission('inventory', 'view');

        $inventoryModel = new Inventory();
        $productModel = new Product();

        $filter = $_GET['filter'] ?? 'all';
        $items = $inventoryModel->getStockOverview($filter);
        $kpis = $inventoryModel->getKpiMetrics();
        $products = $productModel->getAll('name ASC');

        $this->render('admin/inventory/index', [
            'items' => $items,
            'kpis' => $kpis,
            'products' => $products,
            'selectedFilter' => $filter
        ]);
    }

    public function adjust(): void {
        Auth::requirePermission('inventory', 'edit');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(ADMIN_URL . '/?c=inventory');
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $type = $_POST['type'] ?? 'in';
        $quantity = (int)($_POST['quantity'] ?? 0);
        $reference = trim($_POST['reference'] ?? 'Ajuste Manual');
        $notes = trim($_POST['notes'] ?? '');

        if ($productId <= 0 || $quantity < 0) {
            $this->setFlash('error', 'Debe seleccionar un equipo y una cantidad válida.');
            $this->redirect(ADMIN_URL . '/?c=inventory');
        }

        if (!in_array($type, ['in', 'out', 'adjustment'])) {
            $type = 'in';
        }

        $inventoryModel = new Inventory();
        $success = $inventoryModel->registerMovement(
            $productId,
            $type,
            $quantity,
            $reference,
            $notes,
            Auth::user()['id'] ?? null
        );

        if ($success) {
            $typeLabels = [
                'in' => 'Ingreso de existencias',
                'out' => 'Salida de existencias',
                'adjustment' => 'Ajuste de inventario'
            ];
            $this->setFlash('success', "¡{$typeLabels[$type]} registrado correctamente en el Kardex!");
        } else {
            $this->setFlash('error', 'Ocurrió un error al registrar el movimiento en el inventario.');
        }

        $this->redirect(ADMIN_URL . '/?c=inventory');
    }

    public function kardex(): void {
        Auth::requirePermission('inventory', 'view');

        $inventoryModel = new Inventory();
        $productModel = new Product();

        $filters = [
            'product_id' => !empty($_GET['product_id']) ? (int)$_GET['product_id'] : null,
            'type' => !empty($_GET['type']) ? $_GET['type'] : null
        ];

        $kardexRows = $inventoryModel->getKardex($filters, 150);
        $products = $productModel->getAll('name ASC');

        $this->render('admin/inventory/kardex', [
            'kardexRows' => $kardexRows,
            'products' => $products,
            'selectedProduct' => $filters['product_id'],
            'selectedType' => $filters['type']
        ]);
    }
}
