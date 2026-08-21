<?php
/**
 * VICTORQ Industrial - Catálogo Técnico Web
 * Punto de entrada principal (Frontend)
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

$action = $_GET['action'] ?? $_GET['a'] ?? 'index';

$catalogController = new CatalogController();

if ($action === 'quote') {
    $catalogController->quote();
} elseif ($action === 'detail' || $action === 'product' || isset($_GET['id'])) {
    $catalogController->detail((int)($_GET['id'] ?? 0));
} elseif ($action === 'category' || isset($_GET['cat']) || isset($_GET['category']) || isset($_GET['slug'])) {
    $catalogController->category($_GET['slug'] ?? $_GET['cat'] ?? $_GET['category'] ?? '');
} else {
    $catalogController->index();
}
