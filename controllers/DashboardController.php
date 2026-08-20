<?php
/**
 * Controlador de Dashboard y Métricas
 */

class DashboardController extends Controller {

    public function index(): void {
        Auth::requireAuth();

        $productModel = new Product();
        $categoryModel = new Category();
        $quoteModel = new Quote();
        $userModel = new User();
        $tableModel = new TechnicalTable();

        $stats = [
            'total_products' => $productModel->count(),
            'active_products' => $productModel->count('is_active = 1'),
            'total_categories' => $categoryModel->count(),
            'total_quotes' => $quoteModel->count(),
            'pending_quotes' => $quoteModel->count("status = 'pending'"),
            'quoted_quotes' => $quoteModel->count("status = 'quoted'"),
            'total_users' => $userModel->count(),
            'total_tables' => $tableModel->count(),
        ];

        $quoteCounts = $quoteModel->getCountsByStatus();
        $latestQuotes = $quoteModel->getLatest(6);
        $recentProducts = $productModel->getAllWithCategory('p.id DESC LIMIT 5');

        $this->render('admin/dashboard/index', [
            'stats' => $stats,
            'quoteCounts' => $quoteCounts,
            'latestQuotes' => $latestQuotes,
            'recentProducts' => $recentProducts
        ]);
    }

    public function forbidden(): void {
        $this->render('admin/errors/403', [], 'admin');
    }
}
