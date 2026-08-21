<?php
/**
 * Punto de entrada a la Página Pública de Contacto
 * Ejemplo: http://localhost/victorq_catalogo/contact.php
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

$action = $_GET['action'] ?? $_GET['a'] ?? 'publicPage';
$contactController = new ContactController();

if ($action === 'submit' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactController->submit();
} else {
    $contactController->publicPage();
}
