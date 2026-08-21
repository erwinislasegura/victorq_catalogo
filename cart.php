<?php
/**
 * Punto de entrada directo al Carro de Compras
 * Ejemplo: http://localhost/victorq_catalogo/cart.php
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

$action = $_GET['action'] ?? $_GET['a'] ?? 'index';
$cartController = new CartController();

if (method_exists($cartController, $action)) {
    $cartController->$action();
} else {
    $cartController->index();
}
