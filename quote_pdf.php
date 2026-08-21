<?php
/**
 * Punto de entrada para la generación y visualización de Cotización Formal en PDF
 * Ejemplo: http://localhost/victorq_catalogo/quote_pdf.php
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

$cartController = new CartController();
$cartController->quotePdf();
