<?php
$pageTitle = 'Detalle de Cotización #' . $quote['id'];
$statusBadges = [
    'pending' => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle fs-6"><i class="bi bi-clock me-1"></i>Pendiente</span>',
    'in_review' => '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle fs-6"><i class="bi bi-search me-1"></i>En Revisión</span>',
    'quoted' => '<span class="badge bg-success-subtle text-success border border-success-subtle fs-6"><i class="bi bi-check-circle me-1"></i>Cotizado</span>',
    'closed' => '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle fs-6"><i class="bi bi-x-circle me-1"></i>Cerrado</span>',
];
?>
<div class="row g-3">
    <!-- Quote Details -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3 bg-white mb-3">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h6 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-file-earmark-text text-primary me-1"></i> Solicitud de Cotización #<?= $quote['id'] ?>
                    </h6>
                    <?= $statusBadges[$quote['status']] ?? '' ?>
                </div>
                <a href="<?= ADMIN_URL ?>/?c=quote" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 text-xs">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>

            <div class="card-body p-4">
                <!-- Client Info Grid -->
                <div class="row g-3 p-3 bg-light rounded-3 border mb-4 text-xs">
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Nombre del Solicitante:</span>
                        <strong class="text-dark fs-6"><?= htmlspecialchars($quote['client_name']) ?></strong>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Empresa / Organización:</span>
                        <strong class="text-dark fs-6"><?= htmlspecialchars($quote['company'] ?: 'No especificada') ?></strong>
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
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Fecha de Recepción:</span>
                        <span class="text-dark"><?= date('d/m/Y H:i:s', strtotime($quote['created_at'])) ?></span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Dirección IP:</span>
                        <span class="text-dark font-monospace"><?= htmlspecialchars($quote['ip_address'] ?? '127.0.0.1') ?></span>
                    </div>
                </div>

                <!-- Product of Interest -->
                <div class="mb-4">
                    <h6 class="text-xs fw-bold text-muted text-uppercase tracking-wider mb-2">Producto o Línea de Interés:</h6>
                    <div class="p-3 border rounded-3 bg-white d-flex align-items-center gap-3">
                        <div class="avatar-circle bg-primary-subtle text-primary">
                            <i class="bi bi-box-seam fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-primary mb-0"><?= htmlspecialchars($quote['product_interest'] ?: ($product['name'] ?? 'Consulta de Catálogo General')) ?></h6>
                            <?php if ($product): ?>
                                <small class="text-muted">Modelo: <strong><?= htmlspecialchars($product['model']) ?></strong></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Client Message -->
                <div class="mb-4">
                    <h6 class="text-xs fw-bold text-muted text-uppercase tracking-wider mb-2">Mensaje / Requerimiento del Cliente:</h6>
                    <div class="p-3 border rounded-3 bg-white text-dark text-sm bg-light" style="white-space: pre-wrap; line-height: 1.6;">
                        <?= htmlspecialchars($quote['message'] ?: 'Sin mensaje adicional.') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Management & Status Update Form -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 rounded-3 bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-gear text-primary"></i> Gestión y Seguimiento
                </h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= ADMIN_URL ?>/?c=quote&a=view&id=<?= $quote['id'] ?>" method="POST">
                    <!-- Status Selector -->
                    <div class="mb-3">
                        <label for="status" class="form-label text-xs fw-semibold text-muted text-uppercase">Cambiar Estado</label>
                        <select class="form-select form-select-sm" id="status" name="status">
                            <option value="pending" <?= ($quote['status'] === 'pending') ? 'selected' : '' ?>>🔴 Pendiente de Atención</option>
                            <option value="in_review" <?= ($quote['status'] === 'in_review') ? 'selected' : '' ?>>🟡 En Revisión Técnica</option>
                            <option value="quoted" <?= ($quote['status'] === 'quoted') ? 'selected' : '' ?>>🟢 Cotizado / Propuesta Enviada</option>
                            <option value="closed" <?= ($quote['status'] === 'closed') ? 'selected' : '' ?>>⚪ Cerrado / Finalizado</option>
                        </select>
                    </div>

                    <!-- Internal Admin Notes -->
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label text-xs fw-semibold text-muted text-uppercase">Notas de Seguimiento Interno</label>
                        <textarea class="form-control form-control-sm" id="admin_notes" name="admin_notes" rows="5" placeholder="Ej: Contactado el 20/08 por teléfono. Se envió cotización formal N° 1045 por correo."><?= htmlspecialchars($quote['admin_notes'] ?? '') ?></textarea>
                        <small class="text-muted text-xxs">Estas notas son visibles solo por el equipo comercial.</small>
                    </div>

                    <!-- Actions -->
                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold d-flex align-items-center justify-content-center gap-1.5 py-2">
                        <i class="bi bi-save"></i> Guardar Seguimiento
                    </button>
                </form>

                <hr class="my-3">

                <!-- Direct Email / Call buttons -->
                <div class="d-grid gap-2">
                    <a href="mailto:<?= htmlspecialchars($quote['client_email']) ?>?subject=Cotización%20VICTORQ%20-%20<?= urlencode($quote['product_interest'] ?? 'Equipos Industriales') ?>" class="btn btn-sm btn-outline-dark d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-envelope"></i> Redactar Correo
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
