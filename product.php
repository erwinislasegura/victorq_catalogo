<?php
/**
 * Acceso directo a Ficha Detallada de Producto
 * Ejemplo: http://localhost/victorq_catalogo/product.php?id=1
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

$productId = (int)($_GET['id'] ?? 0);
$catalogController = new CatalogController();
$catalogController->detail($productId);
