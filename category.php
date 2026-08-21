<?php
/**
 * Acceso directo a Página de Categoría de Productos
 * Ejemplo: http://localhost/victorq_catalogo/category.php?slug=llaves
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

$slug = $_GET['slug'] ?? $_GET['cat'] ?? $_GET['id'] ?? '';
$catalogController = new CatalogController();
$catalogController->category((string)$slug);
