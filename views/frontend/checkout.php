<?php
/**
 * Vista Pública de Checkout con Pasarela Flow.cl
 * Estilo Oficial Corporativo VICTORQ (Paleta #015B91, Geometría Rectangular Industrial)
 */
$fromCart = $fromCart ?? false;
$cart = $cart ?? [];

if ($fromCart && !empty($cart)) {
    $productName = 'Carro de Compras VICTORQ (' . count($cart) . ' ítems)';
    $productModel = 'CARRO-MULTIPLE';
    $productImage = 'default.png';
    $amount = $cartTotal ?? 150000;
} else {
    $productName = $product['name'] ?? 'Equipo Industrial VICTORQ 700 Bar';
    $productModel = $product['model'] ?? 'VICTORQ-EQUIP';
    $productImage = $product['image'] ?? 'default.png';
    $amount = !empty($product['price']) ? (float)$product['price'] : 150000;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout Seguro | Flow.cl — <?= APP_NAME ?></title>

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
<body>

<!-- TOP ACCENT LINE -->
<div class="top-stripe-victorq"></div>

<!-- HEADER -->
<header class="header-enerpac">
  <div class="top-utility-bar">
    <div class="contenedor">
      <div class="d-flex align-items-center flex-wrap">
        <span><i class="bi bi-shield-lock-fill"></i> Checkout Seguro Encriptado SSL 256-bit</span>
        <span><i class="bi bi-telephone-fill"></i> Asistencia Técnica: <?= APP_PHONE ?></span>
      </div>
      <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/" class="link-backend-top text-decoration-none">
          <i class="bi bi-arrow-left me-1"></i> Volver al Catálogo
        </a>
      </div>
    </div>
  </div>

  <div class="contenedor">
    <nav class="navbar-enerpac">
      <div class="brand-box">
        <a href="<?= BASE_URL ?>/" class="d-flex align-items-center">
          <img src="<?= ASSETS_URL ?>/img/logo.png" alt="<?= APP_NAME ?>">
        </a>
      </div>
      <div class="d-flex align-items-center gap-2">
        <span class="badge bg-light text-dark border p-2 font-monospace text-xs">
          <i class="bi bi-credit-card-2-front text-primary me-1"></i> Powered by <strong>Flow.cl</strong>
        </span>
      </div>
    </nav>
  </div>
</header>

<!-- CHECKOUT CONTENT -->
<section style="padding: 50px 0 80px; background: #f4f6f8; min-height: 80vh;">
  <div class="contenedor">
    <div style="margin-bottom: 24px;">
      <h1 style="font-size: 2rem; color: #0a1118; margin: 0; text-transform: uppercase;">
        CHECKOUT & PAGO EN LÍNEA
      </h1>
      <p style="color: #4b5563; font-size: 0.92rem; margin: 4px 0 0 0;">
        Complete los datos de facturación para ser redirigido a la pasarela segura de Flow.cl (Webpay Plus, Servipag, Mach, Tarjetas bancarias).
      </p>
    </div>

    <?php if (empty($flowConfig['is_active'])): ?>
      <div style="background: #ffffff; border: 2px solid #f59e0b; padding: 30px; margin-bottom: 30px;">
        <div style="display: flex; gap: 16px; align-items: flex-start;">
          <i class="bi bi-exclamation-triangle-fill text-warning fs-1"></i>
          <div>
            <h4 style="margin: 0 0 8px 0; color: #92400e;">Pasarela de Pago en Configuración</h4>
            <p style="color: #b45309; margin: 0 0 16px 0; font-size: 0.9rem;">
              La pasarela Flow.cl se encuentra actualmente en modo de configuración o inactiva en el panel administrativo.
            </p>
            <a href="<?= BASE_URL ?>/#cotizar" class="btn btn-victorq-primary">
              <i class="bi bi-file-earmark-text-fill"></i> Solicitar Cotización Directa
            </a>
          </div>
        </div>
      </div>
    <?php else: ?>

    <div style="display: grid; grid-template-columns: 1.25fr 1fr; gap: 36px; align-items: flex-start;" class="rfq-grid-2">
      
      <!-- FORMULARIO DE COMPRA -->
      <div style="background: #ffffff; border: 1px solid #cdd2d6; padding: 32px; border-top: 4px solid #015B91;">
        <h3 style="font-size: 1.15rem; color: #0a1118; margin-bottom: 20px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; text-transform: uppercase;">
          1. Datos de Facturación y Contacto
        </h3>

        <form action="<?= BASE_URL ?>/checkout.php?action=start" method="POST" id="form-checkout">
          <input type="hidden" name="product_id" value="<?= (int)($product['id'] ?? 0) ?>">
          <input type="hidden" name="product_name" value="<?= htmlspecialchars($productModel . ' — ' . $productName) ?>">

          <div class="form-2col">
            <div class="form-group-enerpac">
              <label for="nombre">Nombre Completo o Razón Social *</label>
              <input type="text" id="nombre" name="nombre" required placeholder="Juan Pérez / Constructora SpA">
            </div>
            <div class="form-group-enerpac">
              <label for="empresa">Empresa / RUT *</label>
              <input type="text" id="empresa" name="empresa" required placeholder="76.123.456-7">
            </div>
          </div>

          <div class="form-2col">
            <div class="form-group-enerpac">
              <label for="email">Correo Electrónico (Comprobante Flow) *</label>
              <input type="email" id="email" name="email" required placeholder="pagos@empresa.cl">
            </div>
            <div class="form-group-enerpac">
              <label for="telefono">Teléfono de Contacto *</label>
              <input type="text" id="telefono" name="telefono" required placeholder="+56 9 1234 5678">
            </div>
          </div>

          <div class="form-group-enerpac">
            <label for="amount">Monto a Pagar (Pesos Chilenos - <?= htmlspecialchars($flowConfig['currency'] ?? 'CLP') ?>) *</label>
            <div class="input-group">
              <input type="number" id="amount" name="amount" value="<?= $amount ?>" min="1000" step="1000" required style="font-family: 'Roboto Mono', monospace; font-size: 1.15rem; font-weight: 700; color: #015B91;">
            </div>
            <small style="color: #6b7280; font-size: 0.75rem; display: block; margin-top: 4px;">Monto neto en moneda nacional (CLP).</small>
          </div>

          <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 16px; margin: 20px 0;">
            <div style="font-size: 0.78rem; font-weight: 700; text-transform: uppercase; color: #0a1118; margin-bottom: 6px;">
              <i class="bi bi-shield-check text-success me-1"></i> Garantía y Procesamiento
            </div>
            <p style="font-size: 0.78rem; color: #4b5563; margin: 0; line-height: 1.4;">
              Al hacer clic en "Pagar con Flow.cl", será redirigido al portal seguro de Flow para seleccionar su método de pago preferido (Webpay Plus Redcompra, Tarjetas de Crédito, Servipag o Transferencia).
            </p>
          </div>

          <button type="submit" class="btn btn-victorq-primary w-100" style="padding: 16px; font-size: 0.95rem;">
            <i class="bi bi-lock-fill"></i>
            <span>Continuar a Pasarela Segura Flow.cl</span>
          </button>
        </form>
      </div>

      <!-- RESUMEN DEL PEDIDO -->
      <div>
        <div style="background: #ffffff; border: 1px solid #cdd2d6; padding: 28px; border-top: 4px solid #111827; position: sticky; top: 90px;">
          <h3 style="font-size: 1.15rem; color: #0a1118; margin-bottom: 18px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; text-transform: uppercase;">
            2. Resumen del Equipo
          </h3>

          <div style="display: flex; gap: 16px; align-items: center; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f0;">
            <div style="width: 80px; height: 80px; border: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: center; padding: 6px; background: #ffffff;">
              <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($productImage) ?>" alt="<?= htmlspecialchars($productName) ?>" style="max-height: 100%; max-width: 100%; object-fit: contain;" onerror="this.src='<?= ASSETS_URL ?>/img/logo.png'">
            </div>
            <div style="flex: 1;">
              <span style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem; font-weight: 900; color: #015B91; text-transform: uppercase;">
                <?= htmlspecialchars($productModel) ?>
              </span>
              <div style="font-size: 0.85rem; font-weight: 700; color: #111827; line-height: 1.3;">
                <?= htmlspecialchars($productName) ?>
              </div>
              <span style="font-size: 0.72rem; color: #6b7280;">Presión 700 Bar Certificada</span>
            </div>
          </div>

          <table style="width: 100%; font-size: 0.85rem; border-collapse: collapse; margin-bottom: 20px;">
            <tr style="border-bottom: 1px solid #f0f0f0;">
              <td style="padding: 8px 0; color: #4b5563;">Entorno Pasarela:</td>
              <td style="padding: 8px 0; text-align: right; font-weight: 700; color: #111827; text-transform: uppercase;">
                <?= htmlspecialchars($flowConfig['environment'] ?? 'sandbox') ?>
              </td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
              <td style="padding: 8px 0; color: #4b5563;">Medios Aceptados:</td>
              <td style="padding: 8px 0; text-align: right; font-weight: 700; color: #015B91;">
                Webpay / Servipag / Mach
              </td>
            </tr>
            <tr style="border-bottom: 1px solid #f0f0f0;">
              <td style="padding: 8px 0; color: #4b5563;">Moneda de Cobro:</td>
              <td style="padding: 8px 0; text-align: right; font-weight: 700; color: #111827;">
                <?= htmlspecialchars($flowConfig['currency'] ?? 'CLP') ?>
              </td>
            </tr>
          </table>

          <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 14px; border-top: 2px solid #015B91;">
            <span style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 800; text-transform: uppercase;">Total a Pagar:</span>
            <span id="display-total" style="font-family: 'Roboto Mono', monospace; font-size: 1.4rem; font-weight: 700; color: #015B91;">
              $<?= number_format($amount, 0, ',', '.') ?> CLP
            </span>
          </div>
        </div>
      </div>

    </div>
    <?php endif; ?>
  </div>
</section>

<!-- GLOBAL CORPORATE FOOTER (CENTRALIZADO) -->
<?php require VIEWS_PATH . '/layouts/public_footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const displayTotal = document.getElementById('display-total');
    if (amountInput && displayTotal) {
        amountInput.addEventListener('input', function() {
            const val = Number(this.value) || 0;
            displayTotal.textContent = '$' + val.toLocaleString('es-CL') + ' CLP';
        });
    }
});
</script>

</body>
</html>
