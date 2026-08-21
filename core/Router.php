<?php
/**
 * Enrutador MVC de la Aplicación
 */

class Router {
    public static function dispatch(string $defaultController = 'DashboardController', string $defaultAction = 'index'): void {
        $c = $_GET['c'] ?? '';
        $a = $_GET['a'] ?? $defaultAction;
        
        // Mapeo de nombres de módulos a controladores
        $controllerMap = [
            'auth' => 'AuthController',
            'dashboard' => 'DashboardController',
            'product' => 'ProductController',
            'category' => 'CategoryController',
            'quote' => 'QuoteController',
            'table' => 'TechnicalTableController',
            'user' => 'UserController',
            'role' => 'RoleController',
            'menu' => 'MenuController',
            'catalog' => 'CatalogController',
            'payment_config' => 'PaymentConfigController',
            'payment' => 'PaymentConfigController',
            'flow' => 'PaymentConfigController',
            'checkout' => 'CheckoutController',
            'contact' => 'ContactController',
            'contacts' => 'ContactController',
            'inventory' => 'InventoryController',
        ];
        
        $controllerName = $controllerMap[strtolower($c)] ?? $defaultController;
        $controllerFile = CONTROLLERS_PATH . '/' . $controllerName . '.php';
        
        if (!file_exists($controllerFile)) {
            header("HTTP/1.0 404 Not Found");
            require_once VIEWS_PATH . '/admin/errors/404.php';
            exit;
        }
        
        require_once $controllerFile;
        
        if (!class_exists($controllerName)) {
            die("Error: Clase controladora '{$controllerName}' no definida.");
        }
        
        $controller = new $controllerName();
        $actionName = $a;
        
        if (!method_exists($controller, $actionName)) {
            header("HTTP/1.0 404 Not Found");
            require_once VIEWS_PATH . '/admin/errors/404.php';
            exit;
        }
        
        $controller->$actionName();
    }
}
