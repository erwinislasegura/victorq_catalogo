<?php
/**
 * Vista de Carro de Compras (Shopping Cart)
 * Estilo Oficial Corporativo VICTORQ (Paleta #015B91, Geometría Rectangular Industrial)
 * Soporte para Cotizaciones Formales en PDF y Checkout Flow.cl
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carro de Compras y Cotizador | <?= APP_NAME ?></title>

<!-- Fonts: Montserrat, Roboto & Roboto Mono -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Roboto:wght@400;500;700&family=Roboto+Mono:wght@500;700;900&display=swap" rel="stylesheet">

<!-- Bootstrap Icons & Bootstrap CSS for Modal Support -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Custom Industrial Catalog CSS -->
<link rel="stylesheet" href="<?= ASSETS_URL ?>/css/catalog.css">

<link rel="shortcut icon" href="<?= ASSETS_URL ?>/img/logo.png" type="image/png">

<style>
/* Estilos específicos para el flujo y stepper del Carro */
.cart-stepper-bar {
  background: #ffffff;
  border: 1px solid #cdd2d6;
  border-top: 4px solid #015B91;
  padding: 16px 24px;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  flex-wrap: wrap;
}
.cart-step-item {
  display: flex;
  align-items: center;
  gap: 10px;
  font-family: 'Montserrat', sans-serif;
  font-size: 0.76rem;
  font-weight: 800;
  text-transform: uppercase;
  color: #64748b;
}
.cart-step-item.active {
  color: #015B91;
}
.cart-step-item.active .step-badge {
  background: #015B91;
  color: #ffffff;
}
.cart-step-item .step-badge {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  background: #e2e8f0;
  color: #475569;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Roboto Mono', monospace;
  font-size: 0.78rem;
  font-weight: 900;
}
.cart-step-divider {
  flex: 1;
  height: 2px;
  background: #e2e8f0;
  min-width: 30px;
}
</style>
</head>
<body style="background: #f4f6f8;">

<div class="top-stripe-victorq"></div>

<!-- HEADER -->
<header class="header-enerpac">
  <div class="top-utility-bar">
    <div class="contenedor">
      <div class="d-flex align-items-center flex-wrap">
        <span><i class="bi bi-shield-check"></i> Despacho y Asistencia Técnica Directa en Faena</span>
        <span><i class="bi bi-telephone-fill"></i> Atención: <?= APP_PHONE ?></span>
      </div>
      <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/" class="link-backend-top text-decoration-none">
          <i class="bi bi-arrow-left me-1"></i> Continuar Comprando
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

      <div class="d-flex align-items-center gap-3">
        <a href="<?= BASE_URL ?>/#catalogo" class="btn btn-victorq-dark" style="padding: 8px 16px; font-size: 0.76rem;">
          <i class="bi bi-grid-fill"></i> Catálogo Completo
        </a>
      </div>
    </nav>
  </div>
</header>

<!-- BREADCRUMB -->
<div style="background: #ffffff; border-bottom: 1px solid #e5e7eb; padding: 10px 0;">
  <div class="contenedor">
    <div class="d-flex align-items-center gap-2 text-xs" style="color: #6b7280; font-weight: 600; text-transform: uppercase;">
      <a href="<?= BASE_URL ?>/" style="color: #015B91; text-decoration: none;">Inicio</a>
      <i class="bi bi-chevron-right" style="font-size: 0.65rem;"></i>
      <a href="<?= BASE_URL ?>/#catalogo" style="color: #015B91; text-decoration: none;">Catálogo</a>
      <i class="bi bi-chevron-right" style="font-size: 0.65rem;"></i>
      <span style="color: #111827;">Carro de Compras & Cotizador</span>
    </div>
  </div>
</div>

<!-- CONTENIDO PRINCIPAL -->
<section style="padding: 30px 0 80px; min-height: 80vh;">
  <div class="contenedor">

    <!-- STEPPER INDUSTRIAL -->
    <div class="cart-stepper-bar">
      <div class="cart-step-item active">
        <span class="step-badge">1</span>
        <span>Equipos Seleccionados</span>
      </div>
      <div class="cart-step-divider"></div>
      <div class="cart-step-item">
        <span class="step-badge">2</span>
        <span>Cotización PDF o Pago Flow</span>
      </div>
      <div class="cart-step-divider"></div>
      <div class="cart-step-item">
        <span class="step-badge">3</span>
        <span>Despacho & Trazabilidad ISO</span>
      </div>
    </div>

    <!-- ENCABEZADO Y ACCIONES RÁPIDAS -->
    <div class="d-flex justify-content-between align-items-end mb-3 flex-wrap gap-2">
      <div>
        <h1 style="font-size: 1.85rem; color: #0a1118; margin: 0; text-transform: uppercase;">
          CARRO DE COMPRAS & HERRAMIENTA RFQ
        </h1>
        <p style="color: #4b5563; font-size: 0.88rem; margin: 4px 0 0 0;">
          Descargue la cotización formal en PDF con validez de 15 días o proceda al pago seguro en línea vía Flow.cl.
        </p>
      </div>

      <?php if (!empty($cart)): ?>
        <a href="<?= BASE_URL ?>/cart.php?action=clear" class="btn btn-sm btn-outline-danger" style="font-size: 0.75rem;" onclick="return confirm('¿Está seguro de vaciar todos los equipos del carro?');">
          <i class="bi bi-trash3-fill"></i> Vaciar Carro
        </a>
      <?php endif; ?>
    </div>

    <?php if (empty($cart)): ?>
      <!-- ESTADO VACÍO -->
      <div style="background: #ffffff; border: 1px solid #cdd2d6; padding: 70px 20px; text-align: center; border-top: 4px solid #015B91;">
        <i class="bi bi-cart-x text-muted" style="font-size: 4.5rem;"></i>
        <h3 style="color: #111827; margin: 18px 0 8px 0; text-transform: uppercase; font-size: 1.4rem;">Su carro de compras está vacío</h3>
        <p style="color: #6b7280; font-size: 0.92rem; margin-bottom: 24px; max-width: 480px; margin-left: auto; margin-right: auto;">
          Seleccione herramientas de torque hidráulico, bombas de 700 bar o cilindros de levante pesado para agregarlos a su cotización o compra.
        </p>
        <a href="<?= BASE_URL ?>/#catalogo" class="btn btn-victorq-primary" style="padding: 14px 28px;">
          <i class="bi bi-grid-fill"></i> Explorar Catálogo de Equipos
        </a>
      </div>
    <?php else: ?>

      <div style="display: grid; grid-template-columns: 1.45fr 1fr; gap: 28px; align-items: flex-start;" class="rfq-grid-2">
        
        <!-- LISTA DE EQUIPOS EN TABLA INDUSTRIAL -->
        <div style="background: #ffffff; border: 1px solid #cdd2d6; border-top: 4px solid #015B91;">
          <div class="tech-table-header" style="background: #0a1118;">
            <h3><i class="bi bi-cart-check-fill text-info me-2"></i>Equipos en el Carro (<?= $totalItems ?>)</h3>
            <span style="font-size: 0.72rem; color: #38bdf8; font-weight: 700; text-transform: uppercase;">VICTORQ INDUSTRIAL 700 BAR</span>
          </div>

          <div class="table-responsive">
            <table class="table align-middle mb-0 text-xs">
              <thead class="table-light">
                <tr>
                  <th class="ps-3 py-3">Equipo / Modelo</th>
                  <th class="py-3 text-center">Precio Unitario</th>
                  <th class="py-3 text-center" style="width: 120px;">Cantidad</th>
                  <th class="py-3 text-end">Subtotal Neto</th>
                  <th class="pe-3 py-3 text-center" style="width: 45px;"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cart as $item): 
                  $itemSubtotal = $item['price'] * $item['quantity'];
                ?>
                  <tr id="cart-row-<?= $item['id'] ?>" style="border-bottom: 1px solid #f0f0f0;">
                    <td class="ps-3 py-3">
                      <div class="d-flex align-items-center gap-3">
                        <div style="width: 64px; height: 64px; border: 1px solid #e5e7eb; padding: 4px; display: flex; align-items: center; justify-content: center; background: #ffffff;">
                          <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="max-height: 100%; max-width: 100%; object-fit: contain;" onerror="this.src='<?= ASSETS_URL ?>/img/logo.png'">
                        </div>
                        <div>
                          <div style="font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 0.85rem; color: #015B91; text-transform: uppercase;">
                            <?= htmlspecialchars($item['model']) ?>
                          </div>
                          <div style="font-weight: 700; color: #111827;">
                            <a href="<?= BASE_URL ?>/product.php?id=<?= $item['id'] ?>" style="color: inherit; text-decoration: none;">
                              <?= htmlspecialchars($item['name']) ?>
                            </a>
                          </div>
                          <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="badge bg-light text-muted border text-xxs"><?= ucfirst($item['category_slug'] ?? 'Equipo') ?></span>
                            <?php if (!empty($item['datasheet_pdf'])): ?>
                              <a href="<?= ASSETS_URL ?>/docs/datasheets/<?= htmlspecialchars($item['datasheet_pdf']) ?>" target="_blank" class="text-xxs text-danger fw-bold text-decoration-none">
                                <i class="bi bi-file-earmark-pdf-fill"></i> Ficha PDF
                              </a>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="text-center font-monospace fw-bold text-dark" style="font-size: 0.82rem;">
                      $<?= number_format($item['price'], 0, ',', '.') ?>
                    </td>
                    <td class="text-center">
                      <div class="input-group input-group-sm" style="max-width: 105px; margin: 0 auto;">
                        <button class="btn btn-outline-secondary btn-qty-change px-2" type="button" data-id="<?= $item['id'] ?>" data-action="dec">-</button>
                        <input type="number" class="form-control text-center font-monospace fw-bold input-qty px-1" value="<?= $item['quantity'] ?>" min="1" max="99" data-id="<?= $item['id'] ?>" readonly>
                        <button class="btn btn-outline-secondary btn-qty-change px-2" type="button" data-id="<?= $item['id'] ?>" data-action="inc">+</button>
                      </div>
                    </td>
                    <td class="text-end font-monospace fw-bold text-primary item-subtotal" style="font-size: 0.86rem;" data-id="<?= $item['id'] ?>">
                      $<?= number_format($itemSubtotal, 0, ',', '.') ?>
                    </td>
                    <td class="pe-3 text-center">
                      <a href="<?= BASE_URL ?>/cart.php?action=remove&id=<?= $item['id'] ?>" class="text-danger fs-6" title="Eliminar del Carro">
                        <i class="bi bi-trash3-fill"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- RESUMEN DE COMPRA & ACCIONES (COTIZACIÓN PDF / PAGO FLOW) -->
        <div>
          <div style="background: #ffffff; border: 1px solid #cdd2d6; padding: 26px; border-top: 4px solid #111827; position: sticky; top: 80px;">
            <h3 style="font-size: 1.15rem; color: #0a1118; margin-bottom: 16px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; text-transform: uppercase;">
              Resumen Financiero
            </h3>

            <table style="width: 100%; font-size: 0.88rem; border-collapse: collapse; margin-bottom: 18px;">
              <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 8px 0; color: #4b5563;">Subtotal Neto:</td>
                <td style="padding: 8px 0; text-align: right; font-family: 'Roboto Mono', monospace; font-weight: 700; color: #111827;">
                  $<?= number_format($subtotal, 0, ',', '.') ?> CLP
                </td>
              </tr>
              <tr style="border-bottom: 1px solid #f0f0f0;">
                <td style="padding: 8px 0; color: #4b5563;">I.V.A. (19%):</td>
                <td style="padding: 8px 0; text-align: right; font-family: 'Roboto Mono', monospace; font-weight: 700; color: #111827;">
                  $<?= number_format($iva, 0, ',', '.') ?> CLP
                </td>
              </tr>
              <tr style="border-bottom: 2px solid #015B91;">
                <td style="padding: 12px 0; font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 1rem; text-transform: uppercase;">
                  TOTAL GENERAL:
                </td>
                <td style="padding: 12px 0; text-align: right; font-family: 'Roboto Mono', monospace; font-size: 1.35rem; font-weight: 900; color: #015B91;">
                  $<?= number_format($total, 0, ',', '.') ?> CLP
                </td>
              </tr>
            </table>

            <!-- ACCIÓN 1: DESCARGAR COTIZACIÓN EN PDF -->
            <button type="button" class="btn btn-victorq-dark w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalCotizacionPdf" style="padding: 14px; font-size: 0.85rem; border-left: 4px solid #ef4444;">
              <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i>
              <span>Descargar Cotización Formal (PDF)</span>
            </button>

            <!-- ACCIÓN 2: PAGAR CON FLOW -->
            <a href="<?= BASE_URL ?>/checkout.php?from=cart" class="btn btn-victorq-primary w-100 mb-3" style="padding: 14px; font-size: 0.88rem;">
              <i class="bi bi-lock-fill"></i>
              <span>Proceder al Pago con Flow.cl</span>
            </a>

            <a href="<?= BASE_URL ?>/#catalogo" class="btn btn-outline-dark w-100 mb-3" style="padding: 10px; font-size: 0.78rem; border-color: #cbd5e1;">
              <i class="bi bi-plus-lg"></i> Seguir Agregando Equipos
            </a>

            <!-- TARJETA DE GARANTÍA INDUSTRIAL -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 14px; font-size: 0.76rem; color: #475569;">
              <div class="fw-bold text-dark mb-1 d-flex align-items-center gap-1">
                <i class="bi bi-patch-check-fill text-primary"></i> Estándar Corporativo VICTORQ:
              </div>
              <ul class="mb-0 ps-3" style="line-height: 1.45;">
                <li>Cotizaciones oficiales con <strong>15 días de validez</strong>.</li>
                <li>Garantía de fábrica por <strong>12 meses</strong>.</li>
                <li>Certificado de calibración trazable individual.</li>
              </ul>
            </div>
          </div>
        </div>

      </div>

    <?php endif; ?>

  </div>
</section>

<!-- MODAL: DATOS DE LA EMPRESA PARA GENERAR COTIZACIÓN PDF -->
<div class="modal fade" id="modalCotizacionPdf" tabindex="-1" aria-labelledby="modalCotizacionPdfLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-dark text-white py-3 border-bottom border-primary border-3">
        <h5 class="modal-title fw-bold text-uppercase d-flex align-items-center gap-2 fs-6" id="modalCotizacionPdfLabel">
          <i class="bi bi-file-earmark-pdf-fill text-danger fs-5"></i>
          <span>Generar Cotización Formal en PDF</span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="<?= BASE_URL ?>/cart.php?action=quotePdf" method="POST" id="form-empresa-pdf">
        <div class="modal-body p-4 bg-white">
          <div class="alert alert-primary py-2 px-3 mb-3 d-flex align-items-center gap-2" style="font-size: 0.78rem;">
            <i class="bi bi-info-circle-fill fs-5"></i>
            <div>
              Complete los datos de su empresa para emitir el documento técnico formal con <strong>validez de 15 días corridos</strong> y especificaciones de cada equipo.
            </div>
          </div>

          <div class="row g-3">
            <div class="col-md-7">
              <label for="empresa" class="form-label text-xs fw-bold text-muted text-uppercase">Razón Social / Empresa *</label>
              <input type="text" class="form-control form-control-sm" id="empresa" name="empresa" required placeholder="Ej: Minera Escondida Ltda. / Constructora SpA">
            </div>

            <div class="col-md-5">
              <label for="rut" class="form-label text-xs fw-bold text-muted text-uppercase">RUT de la Empresa *</label>
              <input type="text" class="form-control form-control-sm font-monospace" id="rut" name="rut" required placeholder="76.123.456-7">
            </div>

            <div class="col-md-6">
              <label for="solicitante" class="form-label text-xs fw-bold text-muted text-uppercase">Nombre del Solicitante / Ingeniero *</label>
              <input type="text" class="form-control form-control-sm" id="solicitante" name="solicitante" required placeholder="Ing. Juan Pérez">
            </div>

            <div class="col-md-6">
              <label for="email" class="form-label text-xs fw-bold text-muted text-uppercase">Correo Electrónico Corporativo *</label>
              <input type="email" class="form-control form-control-sm" id="email" name="email" required placeholder="adquisiciones@empresa.cl">
            </div>

            <div class="col-md-6">
              <label for="telefono" class="form-label text-xs fw-bold text-muted text-uppercase">Teléfono de Contacto *</label>
              <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" required placeholder="+56 9 1234 5678">
            </div>

            <div class="col-md-6">
              <label for="faena" class="form-label text-xs fw-bold text-muted text-uppercase">Faena Minera / Ciudad de Destino</label>
              <input type="text" class="form-control form-control-sm" id="faena" name="faena" placeholder="Ej: Faena Cordillera / Antofagasta">
            </div>

            <div class="col-12">
              <label for="observaciones" class="form-label text-xs fw-bold text-muted text-uppercase">Observaciones / Requerimientos de Despacho</label>
              <textarea class="form-control form-control-sm" id="observaciones" name="observaciones" rows="2" placeholder="Requerimientos de embalaje, certificados o plazos de entrega en faena..."></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer bg-light py-3 d-flex justify-content-between">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-sm btn-victorq-primary px-4 fw-bold">
            <i class="bi bi-file-earmark-pdf-fill me-1"></i> Generar y Descargar Cotización PDF
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- GLOBAL CORPORATE FOOTER (CENTRALIZADO) -->
<?php require VIEWS_PATH . '/layouts/public_footer.php'; ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const BASE_URL = "<?= BASE_URL ?>";

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-qty-change').forEach(btn => {
        btn.addEventListener('click', function() {
            const pId = this.getAttribute('data-id');
            const action = this.getAttribute('data-action');
            const input = document.querySelector(`.input-qty[data-id="${pId}"]`);
            let currentQty = parseInt(input.value) || 1;

            if (action === 'inc') {
                currentQty++;
            } else if (action === 'dec') {
                currentQty = Math.max(1, currentQty - 1);
            }

            input.value = currentQty;

            const fd = new FormData();
            fd.append('product_id', pId);
            fd.append('quantity', currentQty);

            fetch(BASE_URL + '/cart.php?action=update', {
                method: 'POST',
                body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });
    });
});
</script>

</body>
</html>
