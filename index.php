<?php
/**
 * VICTORQ Industrial - Catálogo Técnico Web
 * Punto de entrada principal (Frontend)
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

// Manejo de cotizaciones vía AJAX o router
$action = $_GET['action'] ?? $_GET['a'] ?? 'index';

$catalogController = new CatalogController();

if ($action === 'quote') {
    $catalogController->quote();
} else {
    $catalogController->index();
}
