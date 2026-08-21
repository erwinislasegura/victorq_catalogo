<?php
$pageTitle = 'Detalle de Cotización #' . $quote['id'];
$statusBadges = [
    'pending' => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle fs-6"><i class="bi bi-clock me-1"></i>Pendiente</span>',
    'in_review' => '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle fs-6"><i class="bi bi-search me-1"></i>En Revisión</span>',
    'quoted' => '<span class="badge bg-success-subtle text-success border border-success-subtle fs-6"><i class="bi bi-check-circle me-1"></i>Cotizado</span>',
    'closed' => '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle fs-6"><i class="bi bi-x-circle me-1"></i>Cerrado</span>',
];

$itemsList = !empty($items) ? $items : [];
?>
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2">
        <h4 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-file-earmark-text text-primary"></i>
            <span>Cotización Técnica #<?= $quote['id'] ?></span>
        </h4>
        <?= $statusBadges[$quote['status']] ?? '' ?>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>/quote_pdf.php?quote_id=<?= $quote['id'] ?>" target="_blank" class="btn btn-sm btn-danger d-flex align-items-center gap-1.5 text-xs fw-bold">
            <i class="bi bi-file-earmark-pdf-fill"></i>
            <span>Ver Cotización Oficial PDF (15 Días)</span>
        </a>
        <?php if (Auth::can('quotes', 'create')): ?>
            <a href="<?= ADMIN_URL ?>/?c=quote&a=create" class="btn btn-sm btn-primary d-flex align-items-center gap-1.5 text-xs fw-bold">
                <i class="bi bi-plus-lg"></i>
                <span>Nueva Cotización</span>
            </a>
        <?php endif; ?>
        <a href="<?= ADMIN_URL ?>/?c=quote" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 text-xs">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Detalles de la Cotización -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-building-fill text-primary"></i>
                    <span>Información de la Empresa y Solicitante</span>
                </h6>
                <span class="text-muted text-xxs font-monospace">Folio Ref: COT-<?= date('Ymd', strtotime($quote['created_at'])) ?>-<?= sprintf('%03d', $quote['id']) ?></span>
            </div>

            <div class="card-body p-4">
                <!-- Client Info Grid -->
                <div class="row g-3 p-3 bg-light rounded-3 border mb-4 text-xs">
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Empresa / Razón Social:</span>
                        <strong class="text-dark fs-6"><?= htmlspecialchars($quote['company'] ?: 'No especificada') ?></strong>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Nombre del Solicitante:</span>
                        <strong class="text-dark fs-6"><?= htmlspecialchars($quote['client_name']) ?></strong>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Correo Electrónico:</span>
                        <a href="mailto:<?= htmlspecialchars($quote['client_email']) ?>" class="text-primary text-decoration-none fw-semibold">
                            <i class="bi bi-envelope me-1"></i><?= htmlspecialchars($quote['client_email']) ?>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Teléfono de Contacto:</span>
                        <a href="tel:<?= htmlspecialchars($quote['client_phone']) ?>" class="text-dark text-decoration-none fw-semibold">
                            <i class="bi bi-telephone me-1"></i><?= htmlspecialchars($quote['client_phone'] ?: 'No registrado') ?>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Fecha de Emisión / Solicitud:</span>
                        <span class="text-dark fw-semibold"><?= date('d/m/Y H:i', strtotime($quote['created_at'])) ?></span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Validez de Oferta:</span>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle text-xxs fw-bold">
                            15 Días Corridos (Vence: <?= date('d/m/Y', strtotime($quote['created_at'] . ' +15 days')) ?>)
                        </span>
                    </div>
                </div>

                <!-- Product Table or Single Product Display -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-xs fw-bold text-muted text-uppercase tracking-wider mb-0">Equipos Cotizados en la Propuesta:</h6>
                        <span class="badge bg-light text-dark border"><?= count($itemsList) ?: 1 ?> producto(s)</span>
                    </div>

                    <?php if (!empty($itemsList)): ?>
                        <div class="table-responsive border rounded-3 bg-white">
                            <table class="table table-sm table-hover align-middle mb-0 text-xs">
                                <thead class="table-light text-uppercase text-xxs text-muted">
                                    <tr>
                                        <th class="ps-3" style="width: 50px;">Foto</th>
                                        <th>Modelo / Equipo</th>
                                        <th class="text-center" style="width: 60px;">Cant.</th>
                                        <th class="text-end" style="width: 110px;">Precio Lista</th>
                                        <th class="text-center" style="width: 100px;">Descuento</th>
                                        <th class="text-end pe-3" style="width: 120px;">Subtotal Neto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($itemsList as $it): 
                                        $hasDisc = !empty($it['discount_amount']) && $it['discount_amount'] > 0;
                                    ?>
                                        <tr>
                                            <td class="ps-3 py-2">
                                                <div style="width: 42px; height: 42px; border: 1px solid #e5e7eb; padding: 2px; display: flex; align-items: center; justify-content: center; background: #ffffff;">
                                                    <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($it['image'] ?? 'default.png') ?>" alt="Foto" style="max-height: 100%; max-width: 100%; object-fit: contain;" onerror="this.src='<?= ASSETS_URL ?>/img/logo.png'">
                                                </div>
                                            </td>
                                            <td>
                                                <strong style="font-family: 'Montserrat', sans-serif; color: #015B91; text-transform: uppercase;">
                                                    <?= htmlspecialchars($it['model']) ?>
                                                </strong>
                                                <div class="text-dark fw-bold"><?= htmlspecialchars($it['name']) ?></div>
                                            </td>
                                            <td class="text-center font-monospace fw-bold"><?= (int)$it['quantity'] ?></td>
                                            <td class="text-end font-monospace">$<?= number_format((float)$it['price'], 0, ',', '.') ?></td>
                                            <td class="text-center">
                                                <?php if ($hasDisc): ?>
                                                    <span class="badge bg-danger-subtle text-danger font-monospace">
                                                        -<?= htmlspecialchars($it['discount_val']) ?><?= htmlspecialchars($it['discount_type']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end pe-3 font-monospace fw-bold text-primary">
                                                $<?= number_format((float)$it['line_total'], 0, ',', '.') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <!-- Single product display fallback -->
                        <div class="p-3 border rounded-3 bg-white d-flex align-items-center gap-3">
                            <div style="width: 60px; height: 60px; border: 1px solid #e5e7eb; padding: 4px; display: flex; align-items: center; justify-content: center; background: #ffffff; border-radius: 4px;">
                                <?php if ($product && !empty($product['image'])): ?>
                                    <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($product['image']) ?>" alt="Foto" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                <?php else: ?>
                                    <i class="bi bi-box-seam fs-4 text-primary"></i>
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6 class="fw-bold text-primary mb-0"><?= htmlspecialchars($quote['product_interest'] ?: ($product['name'] ?? 'Consulta General')) ?></h6>
                                    <?php if ($product && !empty($product['price'])): ?>
                                        <span class="font-monospace fw-bold text-dark fs-6">$<?= number_format((float)$product['price'], 0, ',', '.') ?> CLP</span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($product): ?>
                                    <small class="text-muted">Modelo: <strong><?= htmlspecialchars($product['model']) ?></strong> &bull; Serie Hidráulica 700 Bar</small>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Client Message / Technical Breakdown -->
                <div class="mb-2">
                    <h6 class="text-xs fw-bold text-muted text-uppercase tracking-wider mb-2">Desglose de Mensaje / Requerimiento Técnico:</h6>
                    <div class="p-3 border rounded-3 bg-light text-dark text-xs" style="white-space: pre-wrap; line-height: 1.6; font-family: 'Roboto Mono', monospace;">
                        <?= htmlspecialchars($quote['message'] ?: 'Sin mensaje adicional.') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gestión, Resumen Financiero y Acciones -->
    <div class="col-lg-4">
        <!-- Resumen Financiero -->
        <div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-calculator text-primary"></i>
                    <span>Resumen Financiero</span>
                </h6>
            </div>
            <div class="card-body p-4">
                <?php 
                $subtotalNeto = (float)($quote['subtotal_neto'] ?? 0);
                $totalDesc = (float)($quote['discount_amount'] ?? 0);
                $iva = (float)($quote['iva_amount'] ?? round($subtotalNeto * 0.19));
                $totalAmount = (float)($quote['total_amount'] ?? ($subtotalNeto + $iva));
                ?>
                <table class="table table-sm table-borderless text-xs mb-3">
                    <?php if ($totalDesc > 0): ?>
                        <tr>
                            <td class="text-muted">Descuentos Aplicados:</td>
                            <td class="text-end font-monospace fw-bold text-danger">-$<?= number_format($totalDesc, 0, ',', '.') ?> CLP</td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td class="text-muted">Subtotal Neto:</td>
                        <td class="text-end font-monospace fw-bold text-dark fs-6">$<?= number_format($subtotalNeto, 0, ',', '.') ?> CLP</td>
                    </tr>
                    <tr>
                        <td class="text-muted">I.V.A. (19%):</td>
                        <td class="text-end font-monospace fw-bold text-dark">$<?= number_format($iva, 0, ',', '.') ?> CLP</td>
                    </tr>
                    <tr class="border-top table-primary">
                        <td class="fw-bold text-uppercase fs-6 p-2">TOTAL:</td>
                        <td class="text-end font-monospace fw-bold text-primary fs-5 p-2">$<?= number_format($totalAmount, 0, ',', '.') ?> CLP</td>
                    </tr>
                </table>

                <a href="<?= BASE_URL ?>/quote_pdf.php?quote_id=<?= $quote['id'] ?>" target="_blank" class="btn btn-danger btn-sm w-100 py-2 fw-bold d-flex align-items-center justify-content-center gap-2 mb-2">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                    <span>Descargar / Imprimir PDF</span>
                </a>
            </div>
        </div>

        <!-- Tarjeta de Gestión de Estado -->
        <div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-gear text-primary"></i>
                    <span>Gestión y Seguimiento Comercial</span>
                </h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= ADMIN_URL ?>/?c=quote&a=view&id=<?= $quote['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="status" class="form-label text-xs fw-semibold text-muted text-uppercase">Cambiar Estado</label>
                        <select class="form-select form-select-sm" id="status" name="status">
                            <option value="pending" <?= ($quote['status'] === 'pending') ? 'selected' : '' ?>>🔴 Pendiente de Atención</option>
                            <option value="in_review" <?= ($quote['status'] === 'in_review') ? 'selected' : '' ?>>🟡 En Revisión Técnica</option>
                            <option value="quoted" <?= ($quote['status'] === 'quoted') ? 'selected' : '' ?>>🟢 Cotizado / Propuesta Enviada</option>
                            <option value="closed" <?= ($quote['status'] === 'closed') ? 'selected' : '' ?>>⚪ Cerrado / Finalizado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label text-xs fw-semibold text-muted text-uppercase">Notas de Seguimiento Interno</label>
                        <textarea class="form-control form-control-sm" id="admin_notes" name="admin_notes" rows="4" placeholder="Ej: Se envió propuesta técnico-comercial con 10% de descuento autorizado..."><?= htmlspecialchars($quote['admin_notes'] ?? '') ?></textarea>
                        <small class="text-muted text-xxs">Solo visible para el equipo comercial y supervisores.</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold d-flex align-items-center justify-content-center gap-1.5 py-2">
                        <i class="bi bi-save"></i> Guardar Cambios
                    </button>
                </form>
            </div>
        </div>

        <!-- Contacto Rápido -->
        <div class="card shadow-sm border-0 rounded-3 bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-send-fill text-success"></i>
                    <span>Canales de Contacto Directo</span>
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="d-grid gap-2">
                    <a href="mailto:<?= htmlspecialchars($quote['client_email']) ?>?subject=Cotización%20Oficial%20VICTORQ%20-%20<?= urlencode($quote['product_interest'] ?? 'Equipos') ?>" class="btn btn-sm btn-outline-dark d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-envelope-fill text-primary"></i> Enviar Correo Electrónico
                    </a>
                    <?php if (!empty($quote['client_phone'])): ?>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $quote['client_phone']) ?>" target="_blank" class="btn btn-sm btn-outline-success d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-whatsapp"></i> Contactar por WhatsApp
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
