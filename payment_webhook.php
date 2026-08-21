<?php
/**
 * URL de Confirmación Asíncrona de Flow.cl (urlConfirmation / Webhook)
 * Flow envía una notificación POST con el token para verificar y actualizar el estado en segundo plano.
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

$checkoutController = new CheckoutController();
$checkoutController->confirmation();
