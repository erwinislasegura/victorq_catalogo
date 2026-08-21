<?php
/**
 * URL de Retorno de Flow.cl (urlReturn)
 * El pagador es redirigido a este archivo tras completar o cancelar la transacción en Flow.
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

$checkoutController = new CheckoutController();
$checkoutController->result();
