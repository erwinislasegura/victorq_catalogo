<?php
/**
 * Comprobante / Voucher de Pago Flow.cl (Voucher de Retorno)
 * Estilo Oficial Corporativo VICTORQ (Paleta #015B91, Geometría Rectangular Industrial)
 */
$isPaid = ($statusData['status'] ?? ($order['status'] ?? '')) === 'paid';
$isPending = ($statusData['status'] ?? ($order['status'] ?? '')) === 'pending';
$amount = $statusData['amount'] ?? ($order['amount'] ?? 0);
$commerceOrder = $statusData['commerce_order'] ?? ($order['commerce_order'] ?? '—');
$flowOrder = $statusData['flow_order'] ?? ($order['flow_order'] ?? '—');
$productName = $order['product_name'] ?? 'Equipos y Herramientas Industriales VICTORQ';
$payer = $statusData['payer'] ?? ($order['customer_email'] ?? ($order['customer_name'] ?? 'Cliente'));
$paymentData = $statusData['payment_data'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Comprobante de Transacción | Flow.cl — <?= APP_NAME ?></title>

<!-- Fonts: Montserrat, Roboto & Roboto Mono -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Roboto:wght@400;500;700&family=Roboto+Mono:wght@500;700&display=swap" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Custom Industrial Catalog CSS -->
<link rel="stylesheet" href="<?= ASSETS_URL ?>/css/catalog.css">

<link rel="shortcut icon" href="<?= ASSETS_URL ?>/img/logo.png" type="image/png">
</head>
<body style="background: #f4f6f8;">

<div class="top-stripe-victorq"></div>

<header class="header-enerpac">
  <div class="contenedor">
    <nav class="navbar-enerpac">
      <div class="brand-box">
        <a href="<?= BASE_URL ?>/" class="d-flex align-items-center">
          <img src="<?= ASSETS_URL ?>/img/logo.png" alt="<?= APP_NAME ?>">
        </a>
      </div>
      <div class="d-flex align-items-center gap-2">
        <a href="<?= BASE_URL ?>/" class="btn btn-victorq-dark" style="padding: 8px 16px; font-size: 0.76rem;">
          <i class="bi bi-arrow-left"></i> Volver a la Tienda
        </a>
      </div>
    </nav>
  </div>
</header>

<div class="contenedor" style="max-width: 760px; padding: 50px 20px 80px;">
  
  <?php if ($isPaid): ?>
    <!-- VOUCHER DE PAGO APROBADO -->
    <div style="background: #ffffff; border: 1px solid #cdd2d6; border-top: 5px solid #10b981; box-shadow: 0 10px 30px rgba(0,0,0,0.06); padding: 36px;">
      
      <div style="text-align: center; margin-bottom: 28px;">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; background: #ecfdf5; color: #10b981; border-radius: 50%; font-size: 2rem; margin-bottom: 14px;">
          <i class="bi bi-check-lg"></i>
        </div>
        <div style="font-family: 'Montserrat', sans-serif; font-size: 0.76rem; font-weight: 800; text-transform: uppercase; color: #059669; letter-spacing: 0.08em; margin-bottom: 4px;">
          Transacción Aprobada & Verificada
        </div>
        <h1 style="font-size: 1.85rem; color: #0a1118; margin: 0; text-transform: uppercase;">
          ¡PAGO EXITOSO!
        </h1>
        <p style="color: #6b7280; font-size: 0.88rem; margin: 4px 0 0 0;">
          Su transacción ha sido procesada correctamente a través de la pasarela Flow.cl.
        </p>
      </div>

      <!-- TABLA RESUMEN VOUCHER -->
      <div class="tech-table-card mb-4">
        <div class="tech-table-header" style="background: #0a1118; border-bottom: 3px solid #015B91;">
          <h3 style="font-size: 0.88rem;"><i class="bi bi-receipt me-2 text-info"></i>Comprobante de Pago Electrónico</h3>
          <span style="font-family: 'Roboto Mono', monospace; font-size: 0.82rem; color: #38bdf8; font-weight: 700;">
            <?= htmlspecialchars($commerceOrder) ?>
          </span>
        </div>

        <table class="table-enerpac-dense">
          <tbody>
            <tr>
              <td style="width: 40%; font-weight: 700; color: #374151; font-family: 'Montserrat', sans-serif;">N° Orden de Comercio:</td>
              <td style="font-family: 'Roboto Mono', monospace; font-weight: 700; color: #015B91;"><?= htmlspecialchars($commerceOrder) ?></td>
            </tr>
            <tr>
              <td style="font-weight: 700; color: #374151; font-family: 'Montserrat', sans-serif;">N° Transacción Flow:</td>
              <td style="font-family: 'Roboto Mono', monospace;"><?= htmlspecialchars($flowOrder) ?></td>
            </tr>
            <tr>
              <td style="font-weight: 700; color: #374151; font-family: 'Montserrat', sans-serif;">Concepto / Equipo:</td>
              <td><?= htmlspecialchars($productName) ?></td>
            </tr>
            <tr>
              <td style="font-weight: 700; color: #374151; font-family: 'Montserrat', sans-serif;">Pagador / Email:</td>
              <td><?= htmlspecialchars($payer) ?></td>
            </tr>
            <tr>
              <td style="font-weight: 700; color: #374151; font-family: 'Montserrat', sans-serif;">Medio de Pago:</td>
              <td><?= htmlspecialchars($paymentData['media'] ?? 'Webpay Plus / Redcompra') ?></td>
            </tr>
            <tr>
              <td style="font-weight: 700; color: #374151; font-family: 'Montserrat', sans-serif;">Fecha y Hora:</td>
              <td><?= date('d/m/Y H:i:s') ?></td>
            </tr>
            <tr style="background: #f8fafc;">
              <td style="font-weight: 900; color: #0a1118; font-family: 'Montserrat', sans-serif; font-size: 0.95rem;">MONTO TOTAL PAGADO:</td>
              <td style="font-family: 'Roboto Mono', monospace; font-size: 1.25rem; font-weight: 900; color: #059669;">
                $<?= number_format((float)$amount, 0, ',', '.') ?> CLP
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 14px; margin-bottom: 24px; font-size: 0.78rem; color: #4b5563;">
        <i class="bi bi-info-circle-fill text-primary me-1"></i> Se ha enviado una copia de este comprobante al correo del pagador. Un ejecutivo técnico VICTORQ validará el despacho de su pedido.
      </div>

      <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
        <button type="button" class="btn btn-victorq-dark" onclick="window.print()" style="padding: 12px 24px;">
          <i class="bi bi-printer-fill"></i> Imprimir Comprobante
        </button>
        <a href="<?= BASE_URL ?>/#catalogo" class="btn btn-victorq-primary" style="padding: 12px 24px;">
          <i class="bi bi-grid-fill"></i> Volver al Catálogo
        </a>
      </div>

    </div>

  <?php elseif ($isPending): ?>
    <!-- VOUCHER PENDIENTE -->
    <div style="background: #ffffff; border: 1px solid #cdd2d6; border-top: 5px solid #f59e0b; padding: 36px; text-align: center;">
      <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; background: #fef3c7; color: #d97706; border-radius: 50%; font-size: 2rem; margin-bottom: 14px;">
        <i class="bi bi-hourglass-split"></i>
      </div>
      <h1 style="font-size: 1.85rem; color: #0a1118; margin-bottom: 8px; text-transform: uppercase;">
        PAGO PENDIENTE DE CONFIRMACIÓN
      </h1>
      <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 24px;">
        Su pago para la orden <strong><?= htmlspecialchars($commerceOrder) ?></strong> está siendo procesado por su entidad bancaria o punto de recaudación (Servipag/Transferencia).
      </p>
      <a href="<?= BASE_URL ?>/" class="btn btn-victorq-primary">Volver al Inicio</a>
    </div>

  <?php else: ?>
    <!-- VOUCHER RECHAZADO / CANCELADO -->
    <div style="background: #ffffff; border: 1px solid #cdd2d6; border-top: 5px solid #ef4444; padding: 36px; text-align: center;">
      <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; background: #fee2e2; color: #dc2626; border-radius: 50%; font-size: 2rem; margin-bottom: 14px;">
        <i class="bi bi-x-lg"></i>
      </div>
      <h1 style="font-size: 1.85rem; color: #0a1118; margin-bottom: 8px; text-transform: uppercase;">
        TRANSACCIÓN NO COMPLETADA
      </h1>
      <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 24px;">
        La transacción no pudo ser autorizada o fue cancelada por el usuario en el portal de Flow.
      </p>
      <div style="display: flex; gap: 12px; justify-content: center;">
        <a href="<?= BASE_URL ?>/checkout.php?product_id=<?= (int)($order['product_id'] ?? 0) ?>" class="btn btn-victorq-primary">
          <i class="bi bi-arrow-repeat"></i> Reintentar Pago
        </a>
        <a href="<?= BASE_URL ?>/" class="btn btn-victorq-dark">Volver al Catálogo</a>
      </div>
    </div>
  <?php endif; ?>

</div>

<!-- GLOBAL CORPORATE FOOTER (CENTRALIZADO) -->
<?php require VIEWS_PATH . '/layouts/public_footer.php'; ?>

</body>
</html>
