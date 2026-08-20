<?php
/**
 * Controlador de Cotizaciones
 */

class QuoteController extends Controller {

    public function index(): void {
        Auth::requirePermission('quotes', 'view');

        $quoteModel = new Quote();
        $quotes = $quoteModel->getAllWithProduct();
        $counts = $quoteModel->getCountsByStatus();

        $this->render('admin/quotes/index', [
            'quotes' => $quotes,
            'counts' => $counts
        ]);
    }

    public function view(): void {
        Auth::requirePermission('quotes', 'view');

        $id = (int)($_GET['id'] ?? 0);
        $quoteModel = new Quote();
        $quote = $quoteModel->find($id);

        if (!$quote) {
            $this->setFlash('error', 'Solicitud de cotización no encontrada.');
            $this->redirect(ADMIN_URL . '/?c=quote');
        }

        // Si se actualiza el estado o notas
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requirePermission('quotes', 'edit');

            $status = $_POST['status'] ?? $quote['status'];
            $adminNotes = trim($_POST['admin_notes'] ?? '');

            $quoteModel->update($id, [
                'status' => $status,
                'admin_notes' => $adminNotes
            ]);

            $this->setFlash('success', 'Cotización actualizada correctamente.');
            $this->redirect(ADMIN_URL . '/?c=quote&a=view&id=' . $id);
        }

        $product = null;
        if (!empty($quote['product_id'])) {
            $productModel = new Product();
            $product = $productModel->find((int)$quote['product_id']);
        }

        $this->render('admin/quotes/view', [
            'quote' => $quote,
            'product' => $product
        ]);
    }

    public function delete(): void {
        Auth::requirePermission('quotes', 'delete');

        $id = (int)($_GET['id'] ?? 0);
        $quoteModel = new Quote();
        $quote = $quoteModel->find($id);

        if ($quote) {
            $quoteModel->delete($id);
            $this->setFlash('success', 'Cotización eliminada correctamente.');
        }

        $this->redirect(ADMIN_URL . '/?c=quote');
    }
}
