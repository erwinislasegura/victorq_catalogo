<?php
/**
 * Vista de Cotización Formal en PDF (Documento de Ingeniería y Ventas A4)
 * Estilo Oficial Corporativo VICTORQ (Paleta #015B91, #00A3E0, #0A1118)
 * Validez de Oferta: 15 Días Corridos
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cotización Oficial <?= htmlspecialchars($company['folio']) ?> | <?= APP_NAME ?></title>

<!-- Fonts: Montserrat, Roboto & Roboto Mono -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Roboto:wght@400;500;700&family=Roboto+Mono:wght@500;700;900&display=swap" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="shortcut icon" href="<?= ASSETS_URL ?>/img/logo.png" type="image/png">

<style>
/* ==========================================================================
   ESTILOS DE LA COTIZACIÓN OFICIAL EN PDF (A4 INDUSTRIAL VECTORIAL)
   ========================================================================== */
:root {
  --vq-blue: #015B91;
  --vq-blue-dark: #003657;
  --vq-cyan: #00A3E0;
  --vq-dark: #0a1118;
  --vq-text: #1e293b;
  --vq-muted: #64748b;
  --vq-border: #cbd5e1;
  --vq-bg-light: #f8fafc;
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  color: var(--vq-text);
  background: #e2e8f0;
  font-size: 12px;
  line-height: 1.4;
  -webkit-font-smoothing: antialiased;
}

/* Barra Superior de Acciones de Usuario (No imprimible) */
.toolbar-actions {
  background: #0a1118;
  color: #ffffff;
  padding: 12px 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: sticky;
  top: 0;
  z-index: 1000;
  box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}
.toolbar-actions .btn-tool {
  padding: 8px 18px;
  font-family: 'Montserrat', sans-serif;
  font-size: 0.78rem;
  font-weight: 800;
  text-transform: uppercase;
  border-radius: 2px;
  text-decoration: none;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.15s;
  border: 1px solid transparent;
}
.btn-print {
  background: #015B91;
  color: #ffffff;
  border-color: #00A3E0;
}
.btn-print:hover {
  background: #00A3E0;
  color: #0a1118;
}
.btn-back {
  background: #1e293b;
  color: #f1f5f9;
  border-color: #334155;
}
.btn-back:hover {
  background: #334155;
  color: #ffffff;
}

/* Hoja A4 Contenedora */
.page-a4 {
  width: 210mm;
  min-height: 297mm;
  margin: 20px auto 40px;
  background: #ffffff;
  padding: 18mm 16mm 16mm;
  box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  position: relative;
  display: flex;
  flex-direction: column;
}

/* Franja decorativa corporativa */
.doc-top-bar {
  height: 6px;
  background: linear-gradient(90deg, #015B91 0%, #00A3E0 60%, #0a1118 100%);
  margin-bottom: 20px;
}

/* Encabezado */
.doc-header {
  display: grid;
  grid-template-columns: 1fr 1.2fr;
  gap: 20px;
  align-items: flex-start;
  padding-bottom: 16px;
  border-bottom: 2px solid #015B91;
  margin-bottom: 16px;
}
.brand-emitter-box img {
  max-height: 48px;
  margin-bottom: 8px;
}
.brand-emitter-box .company-title {
  font-family: 'Montserrat', sans-serif;
  font-size: 0.88rem;
  font-weight: 900;
  color: #0a1118;
  letter-spacing: 0.05em;
  text-transform: uppercase;
}
.brand-emitter-box .company-info {
  font-size: 0.74rem;
  color: var(--vq-muted);
  line-height: 1.35;
}

/* Folio y Validez de Oferta */
.doc-folio-box {
  background: #f8fafc;
  border: 1px solid #cbd5e1;
  border-left: 4px solid #015B91;
  padding: 10px 14px;
}
.doc-folio-box .folio-title {
  font-family: 'Montserrat', sans-serif;
  font-size: 0.75rem;
  font-weight: 800;
  text-transform: uppercase;
  color: #015B91;
  letter-spacing: 0.04em;
}
.doc-folio-box .folio-number {
  font-family: 'Roboto Mono', monospace;
  font-size: 1.15rem;
  font-weight: 900;
  color: #0a1118;
  margin: 2px 0 6px;
}
.folio-meta-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 6px;
  font-size: 0.72rem;
  padding-top: 6px;
  border-top: 1px solid #e2e8f0;
}
.validity-alert-badge {
  grid-column: span 2;
  background: #eff6ff;
  border: 1px solid #bfdbfe;
  color: #1e40af;
  padding: 4px 8px;
  font-family: 'Montserrat', sans-serif;
  font-size: 0.72rem;
  font-weight: 800;
  text-transform: uppercase;
  text-align: center;
  margin-top: 4px;
}

/* Cuadro de Datos de la Empresa / Cliente */
.section-client-box {
  background: #ffffff;
  border: 1px solid #cbd5e1;
  padding: 12px 14px;
  margin-bottom: 16px;
}
.client-box-header {
  font-family: 'Montserrat', sans-serif;
  font-size: 0.74rem;
  font-weight: 800;
  text-transform: uppercase;
  color: #0a1118;
  border-bottom: 1px solid #e2e8f0;
  padding-bottom: 4px;
  margin-bottom: 8px;
  display: flex;
  align-items: center;
  gap: 6px;
}
.client-grid-data {
  display: grid;
  grid-template-columns: 1.4fr 1fr;
  gap: 6px 16px;
  font-size: 0.74rem;
}
.client-grid-data .data-row {
  display: flex;
  gap: 6px;
}
.client-grid-data .data-label {
  font-weight: 700;
  color: #475569;
  min-width: 90px;
}
.client-grid-data .data-val {
  font-weight: 500;
  color: #0f172a;
}

/* Tabla de Productos */
.doc-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 14px;
  font-size: 0.72rem;
}
.doc-table thead th {
  background: #0a1118;
  color: #ffffff;
  font-family: 'Montserrat', sans-serif;
  font-size: 0.68rem;
  font-weight: 800;
  text-transform: uppercase;
  padding: 7px 8px;
  text-align: left;
  border: 1px solid #0a1118;
}
.doc-table thead th.text-center { text-align: center; }
.doc-table thead th.text-right { text-align: right; }
.doc-table tbody td {
  padding: 7px 8px;
  border: 1px solid #e2e8f0;
  vertical-align: middle;
}
.doc-table tbody tr:nth-child(even) {
  background: #f8fafc;
}
.prod-thumb-cell {
  width: 48px;
  height: 48px;
  text-align: center;
  padding: 2px !important;
}
.prod-thumb-cell img {
  max-width: 44px;
  max-height: 44px;
  object-fit: contain;
}
.prod-spec-mini {
  display: block;
  font-size: 0.68rem;
  color: #475569;
  margin-top: 3px;
  font-family: 'Roboto Mono', monospace;
}

/* Bloque Financiero y Totales */
.financial-block {
  display: grid;
  grid-template-columns: 1.3fr 1fr;
  gap: 16px;
  margin-bottom: 16px;
}
.notes-container {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  padding: 8px 10px;
  font-size: 0.70rem;
  color: #475569;
}
.totals-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.74rem;
}
.totals-table td {
  padding: 5px 8px;
  border-bottom: 1px solid #e2e8f0;
}
.totals-table tr.total-row td {
  background: #015B91;
  color: #ffffff;
  font-family: 'Montserrat', sans-serif;
  font-size: 0.88rem;
  font-weight: 900;
  border-bottom: none;
}
.totals-table tr.total-row .total-val {
  font-family: 'Roboto Mono', monospace;
  text-align: right;
}

/* Condiciones Comerciales */
.section-terms-box {
  border: 1px solid #cbd5e1;
  padding: 10px 12px;
  background: #ffffff;
  margin-bottom: 16px;
}
.terms-title {
  font-family: 'Montserrat', sans-serif;
  font-size: 0.72rem;
  font-weight: 800;
  text-transform: uppercase;
  color: #0a1118;
  margin-bottom: 6px;
  border-bottom: 1px solid #e2e8f0;
  padding-bottom: 3px;
}
.terms-list {
  list-style: none;
  font-size: 0.68rem;
  color: #475569;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4px 14px;
}
.terms-list li strong {
  color: #0f172a;
}

/* Firma y Pie de Documento */
.doc-footer-signatures {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  padding-top: 10px;
  margin-top: auto;
  border-top: 1px solid #e2e8f0;
}
.signature-box {
  text-align: center;
  font-size: 0.68rem;
  color: #475569;
}
.signature-line {
  width: 180px;
  height: 1px;
  background: #94a3b8;
  margin: 35px auto 4px;
}
.digital-stamp {
  font-family: 'Montserrat', sans-serif;
  font-weight: 800;
  color: #015B91;
  font-size: 0.72rem;
  text-transform: uppercase;
}

/* Reglas de Impresión */
@media print {
  body {
    background: #ffffff !important;
  }
  .no-print, .toolbar-actions {
    display: none !important;
  }
  .page-a4 {
    margin: 0 !important;
    padding: 10mm 12mm !important;
    width: 100% !important;
    min-height: auto !important;
    box-shadow: none !important;
  }
}
</style>
</head>
<body>

<!-- BARRA DE ACCIONES FLOTANTE (NO IMPRIMIBLE) -->
<div class="toolbar-actions no-print">
  <div class="d-flex align-items-center gap-3">
    <a href="<?= BASE_URL ?>/cart.php" class="btn-tool btn-back">
      <i class="bi bi-arrow-left"></i> Volver al Carro
    </a>
    <span style="font-size: 0.82rem; color: #94a3b8;">
      Cotización Oficial Generada: <strong style="color: #38bdf8; font-family: 'Roboto Mono', monospace;"><?= htmlspecialchars($company['folio']) ?></strong>
    </span>
  </div>

  <div class="d-flex align-items-center gap-2">
    <button type="button" class="btn-tool btn-print" onclick="window.print()">
      <i class="bi bi-printer-fill"></i> Guardar / Descargar PDF
    </button>
    <a href="<?= BASE_URL ?>/#catalogo" class="btn-tool btn-back">
      <i class="bi bi-grid-fill"></i> Catálogo Web
    </a>
  </div>
</div>

<!-- HOJA A4 DE COTIZACIÓN -->
<div class="page-a4">
  <div class="doc-top-bar"></div>

  <!-- ENCABEZADO Y FOLIO -->
  <header class="doc-header">
    <div class="brand-emitter-box">
      <img src="<?= ASSETS_URL ?>/img/logo.png" alt="<?= APP_NAME ?>">
      <div class="company-title">VICTORQ INDUSTRIAL SpA</div>
      <div class="company-info">
        <strong>RUT:</strong> 76.890.123-K &bull; <strong>Giro:</strong> Comercialización e Ingeniería en Torque Hidráulico<br>
        <strong>Dirección:</strong> Av. Industrial 4500, Santiago de Chile<br>
        <strong>Mesa Central:</strong> <?= APP_PHONE ?> &bull; <strong>Email:</strong> <?= APP_EMAIL ?><br>
        <strong>Portal Técnico:</strong> www.victorq.com
      </div>
    </div>

    <!-- FOLIO Y FECHAS -->
    <div class="doc-folio-box">
      <div class="folio-title">Cotización Técnica Formal</div>
      <div class="folio-number"><?= htmlspecialchars($company['folio']) ?></div>

      <div class="folio-meta-grid">
        <div><strong>Fecha Emisión:</strong> <?= $company['fecha_emision'] ?></div>
        <div><strong>Vencimiento:</strong> <?= $company['fecha_vencimiento'] ?></div>
        <div class="validity-alert-badge">
          <i class="bi bi-shield-check"></i> Validez de la Oferta: 15 Días Corridos
        </div>
      </div>
    </div>
  </header>

  <!-- DATOS DEL CLIENTE / EMPRESA -->
  <section class="section-client-box">
    <div class="client-box-header">
      <i class="bi bi-building-fill text-primary"></i>
      <span>Información del Cliente y Destino</span>
    </div>
    <div class="client-grid-data">
      <div class="data-row">
        <span class="data-label">Razón Social:</span>
        <span class="data-val" style="font-weight: 700; color: #015B91;"><?= htmlspecialchars($company['empresa'] ?: 'Cliente Industrial') ?></span>
      </div>
      <div class="data-row">
        <span class="data-label">RUT Empresa:</span>
        <span class="data-val" style="font-family: 'Roboto Mono', monospace; font-weight: 700;"><?= htmlspecialchars($company['rut'] ?: 'Sin RUT') ?></span>
      </div>
      <div class="data-row">
        <span class="data-label">Atención a:</span>
        <span class="data-val"><?= htmlspecialchars($company['solicitante'] ?: 'Departamento de Adquisiciones') ?></span>
      </div>
      <div class="data-row">
        <span class="data-label">Teléfono:</span>
        <span class="data-val"><?= htmlspecialchars($company['telefono'] ?: APP_PHONE) ?></span>
      </div>
      <div class="data-row">
        <span class="data-label">Email:</span>
        <span class="data-val"><?= htmlspecialchars($company['email'] ?: 'contacto@empresa.cl') ?></span>
      </div>
      <div class="data-row">
        <span class="data-label">Faena / Destino:</span>
        <span class="data-val"><?= htmlspecialchars($company['faena'] ?: 'Santiago / Despacho a Faena') ?></span>
      </div>
    </div>
  </section>

  <!-- TABLA DE EQUIPOS COTIZADOS -->
  <table class="doc-table">
    <thead>
      <tr>
        <th class="text-center" style="width: 25px;">#</th>
        <th class="text-center" style="width: 44px;">Foto</th>
        <th style="width: 105px;">Modelo / Serie</th>
        <th>Descripción del Equipo & Especificaciones Técnicas</th>
        <th class="text-center" style="width: 40px;">Cant.</th>
        <th class="text-right" style="width: 85px;">Precio Lista</th>
        <th class="text-center" style="width: 65px;">Desc.</th>
        <th class="text-right" style="width: 90px;">Total Neto</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $itemIdx = 1;
      foreach ($enrichedCart as $item): 
        $specsArr = $item['specs'] ?? [];
        $specsText = [];
        foreach ($specsArr as $sk => $sv) {
          $specsText[] = "{$sk}: {$sv}";
        }
        $specsFormatted = !empty($specsText) ? implode(' &bull; ', array_slice($specsText, 0, 4)) : 'Presión 700 Bar (10.000 PSI) &bull; Certificación de Fábrica';
        $hasDisc = !empty($item['discount_amount']) && $item['discount_amount'] > 0;
      ?>
        <tr>
          <td class="text-center font-monospace fw-bold" style="color: #64748b;"><?= sprintf('%02d', $itemIdx++) ?></td>
          <td class="prod-thumb-cell">
            <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" onerror="this.src='<?= ASSETS_URL ?>/img/logo.png'">
          </td>
          <td>
            <strong style="font-family: 'Montserrat', sans-serif; font-size: 0.74rem; color: #015B91; text-transform: uppercase;">
              <?= htmlspecialchars($item['model']) ?>
            </strong>
            <div style="font-size: 0.65rem; color: #64748b;"><?= ucfirst($item['category_slug'] ?? 'Equipo') ?></div>
          </td>
          <td>
            <div style="font-weight: 700; color: #0f172a; font-size: 0.74rem; line-height: 1.25;">
              <?= htmlspecialchars($item['name']) ?>
            </div>
            <span class="prod-spec-mini"><?= $specsFormatted ?></span>
          </td>
          <td class="text-center font-monospace fw-bold" style="font-size: 0.8rem;"><?= (int)$item['quantity'] ?></td>
          <td class="text-right font-monospace" style="font-size: 0.74rem;">$<?= number_format($item['price'], 0, ',', '.') ?></td>
          <td class="text-center font-monospace" style="font-size: 0.72rem;">
            <?php if ($hasDisc): ?>
              <span style="color: #dc2626; font-weight: 700;">-<?= htmlspecialchars($item['discount_val']) ?><?= htmlspecialchars($item['discount_type']) ?></span>
            <?php else: ?>
              <span style="color: #94a3b8;">-</span>
            <?php endif; ?>
          </td>
          <td class="text-right font-monospace fw-bold" style="font-size: 0.78rem; color: #015B91;">$<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- BLOQUE FINANCIERO Y TOTALES -->
  <div class="financial-block">
    <div class="notes-container">
      <strong style="color: #0f172a; display: block; margin-bottom: 2px; font-family: 'Montserrat', sans-serif;">Observaciones / Notas del Pedido:</strong>
      <p style="margin: 0; line-height: 1.35;">
        <?= !empty($company['observaciones']) ? nl2br(htmlspecialchars($company['observaciones'])) : 'Equipos nuevos con embalaje de fábrica para trabajo pesado en minería. Incluye manual de usuario y protocolos de seguridad.' ?>
      </p>
    </div>

    <!-- TABLA DE TOTALES -->
    <table class="totals-table">
      <?php if (!empty($totalDiscounts) && $totalDiscounts > 0): ?>
        <tr>
          <td style="color: #475569; font-weight: 700;">Subtotal Lista (Bruto):</td>
          <td style="text-align: right; font-family: 'Roboto Mono', monospace; font-weight: 700; color: #0f172a;">
            $<?= number_format($subtotalGross ?? ($subtotal + $totalDiscounts), 0, ',', '.') ?>
          </td>
        </tr>
        <tr>
          <td style="color: #dc2626; font-weight: 700;">Descuentos Aplicados:</td>
          <td style="text-align: right; font-family: 'Roboto Mono', monospace; font-weight: 700; color: #dc2626;">
            -$<?= number_format($totalDiscounts, 0, ',', '.') ?>
          </td>
        </tr>
      <?php endif; ?>
      <tr>
        <td style="color: #475569; font-weight: 700;">Subtotal Neto (CLP):</td>
        <td style="text-align: right; font-family: 'Roboto Mono', monospace; font-weight: 700; color: #0f172a;">
          $<?= number_format($subtotal, 0, ',', '.') ?>
        </td>
      </tr>
      <tr>
        <td style="color: #475569; font-weight: 700;">I.V.A. (19%):</td>
        <td style="text-align: right; font-family: 'Roboto Mono', monospace; font-weight: 700; color: #0f172a;">
          $<?= number_format($iva, 0, ',', '.') ?>
        </td>
      </tr>
      <tr class="total-row">
        <td>TOTAL GENERAL:</td>
        <td class="total-val">$<?= number_format($total, 0, ',', '.') ?> CLP</td>
      </tr>
    </table>
  </div>

  <!-- CONDICIONES COMERCIALES Y DE SERVICIO -->
  <section class="section-terms-box">
    <div class="terms-title">Condiciones Comerciales y Garantía Técnica</div>
    <ul class="terms-list">
      <li><strong>1. Validez de la Propuesta:</strong> 15 días corridos a contar de la fecha de emisión.</li>
      <li><strong>2. Plazo de Entrega:</strong> Inmediato sujeto a stock / 5 días hábiles en faena.</li>
      <li><strong>3. Forma de Pago:</strong> Transferencia, Pasarela Flow o Crédito 30 días con O/C aprobada.</li>
      <li><strong>4. Garantía de Fábrica:</strong> 12 meses contra defectos de fabricación o materiales.</li>
      <li><strong>5. Calibración & Presión:</strong> Protocolo de prueba 700 bar y trazabilidad bajo norma ISO 9001.</li>
      <li><strong>6. Moneda:</strong> Precios en Pesos Chilenos (CLP) con desglose de impuestos vigente.</li>
    </ul>
  </section>

  <!-- FIRMA Y PIE DE DOCUMENTO -->
  <footer class="doc-footer-signatures">
    <div class="signature-box">
      <div class="signature-line"></div>
      <div class="digital-stamp">DEPARTAMENTO DE VENTAS TÉCNICAS</div>
      <div>VICTORQ INDUSTRIAL SpA &bull; División Potencia Hidráulica</div>
    </div>
    <div class="signature-box">
      <div class="signature-line"></div>
      <div style="font-weight: 700; color: #0f172a;">ACEPTACIÓN DEL CLIENTE (FIRMA / TIMBRE)</div>
      <div>Razón Social: <?= htmlspecialchars($company['empresa'] ?: 'Cliente') ?></div>
    </div>
  </footer>
</div>

</body>
</html>
