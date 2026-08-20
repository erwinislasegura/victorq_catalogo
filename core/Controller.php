<?php
/**
 * Controlador Base MVC
 */

abstract class Controller {
    protected function render(string $viewPath, array $data = [], string $layout = 'admin'): void {
        // Extraer variables para la vista
        extract($data);
        
        // Variables de entorno para vistas
        $currentUser = Auth::user();
        $isLoggedIn = Auth::check();
        $currentModule = $_GET['c'] ?? 'dashboard';
        $currentAction = $_GET['a'] ?? 'index';
        
        // Menús autorizados para el rol actual
        $menuModel = new Menu();
        $userMenus = $isLoggedIn ? $menuModel->getMenusForRole(Auth::user()['role_id'] ?? 0) : [];
        
        // Alertas Flash
        $flashSuccess = $_SESSION['flash_success'] ?? null;
        $flashError = $_SESSION['flash_error'] ?? null;
        $flashWarning = $_SESSION['flash_warning'] ?? null;
        $flashInfo = $_SESSION['flash_info'] ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error'], $_SESSION['flash_warning'], $_SESSION['flash_info']);
        
        $viewFile = VIEWS_PATH . '/' . $viewPath . '.php';
        
        if (!file_exists($viewFile)) {
            die("Error: No se encontró la vista: " . htmlspecialchars($viewFile));
        }
        
        if ($layout === 'none' || $layout === 'auth') {
            require $viewFile;
        } else {
            // Orden canónico del layout: Header -> Sidebar -> Navbar -> Vista -> Footer
            require VIEWS_PATH . '/layouts/admin_header.php';
            require VIEWS_PATH . '/layouts/admin_sidebar.php';
            require VIEWS_PATH . '/layouts/admin_navbar.php';
            require $viewFile;
            require VIEWS_PATH . '/layouts/admin_footer.php';
        }
    }

    protected function json(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function redirect(string $url): void {
        header("Location: {$url}");
        exit;
    }

    protected function setFlash(string $type, string $message): void {
        $_SESSION["flash_{$type}"] = $message;
    }
}
