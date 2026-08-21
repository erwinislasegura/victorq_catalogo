<?php
/**
 * Punto de entrada público al Checkout Flow.cl
 * Ejemplo: http://localhost/victorq_catalogo/checkout.php?id=1
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

$action = $_GET['action'] ?? $_GET['a'] ?? 'index';
$checkoutController = new CheckoutController();

if ($action === 'start' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkoutController->start();
} else {
    $checkoutController->index();
}
