<?php
$pageTitle = 'Detalle de Mensaje #' . $contact['id'];
$statusBadges = [
    'unread' => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle fs-6"><i class="bi bi-envelope-fill me-1"></i>No Leído</span>',
    'read' => '<span class="badge bg-info-subtle text-info-emphasis border border-info-subtle fs-6"><i class="bi bi-envelope-open me-1"></i>Leído</span>',
    'responded' => '<span class="badge bg-success-subtle text-success border border-success-subtle fs-6"><i class="bi bi-check-circle-fill me-1"></i>Respondido</span>',
    'archived' => '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle fs-6"><i class="bi bi-archive me-1"></i>Archivado</span>',
];
?>
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2">
        <h4 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-envelope-paper-fill text-primary"></i>
            <span>Mensaje de Contacto #<?= $contact['id'] ?></span>
        </h4>
        <?= $statusBadges[$contact['status']] ?? '' ?>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= ADMIN_URL ?>/?c=quote&a=create" class="btn btn-sm btn-primary d-flex align-items-center gap-1.5 text-xs fw-bold">
            <i class="bi bi-file-earmark-plus-fill"></i>
            <span>Emitir Cotización a este Cliente</span>
        </a>
        <a href="<?= ADMIN_URL ?>/?c=contact" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 text-xs">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Información del Mensaje -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-person-lines-fill text-primary"></i>
                    <span>Información del Contacto</span>
                </h6>
                <span class="text-muted text-xxs"><?= date('d/m/Y H:i:s', strtotime($contact['created_at'])) ?></span>
            </div>

            <div class="card-body p-4">
                <!-- Info Grid -->
                <div class="row g-3 p-3 bg-light rounded-3 border mb-4 text-xs">
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Nombre del Solicitante:</span>
                        <strong class="text-dark fs-6"><?= htmlspecialchars($contact['name']) ?></strong>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Empresa / Razón Social:</span>
                        <strong class="text-dark fs-6"><?= htmlspecialchars($contact['company']) ?></strong>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">RUT Empresa:</span>
                        <span class="text-dark font-monospace fw-bold"><?= htmlspecialchars($contact['rut'] ?: 'No informado') ?></span>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Correo Electrónico:</span>
                        <a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="text-primary text-decoration-none fw-semibold">
                            <i class="bi bi-envelope me-1"></i><?= htmlspecialchars($contact['email']) ?>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Teléfono / Celular:</span>
                        <a href="tel:<?= htmlspecialchars($contact['phone']) ?>" class="text-dark text-decoration-none fw-semibold">
                            <i class="bi bi-telephone me-1"></i><?= htmlspecialchars($contact['phone']) ?>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase text-xxs fw-bold d-block">Dirección IP:</span>
                        <span class="text-dark font-monospace"><?= htmlspecialchars($contact['ip_address'] ?? '127.0.0.1') ?></span>
                    </div>
                </div>

                <!-- Asunto / Motivo -->
                <div class="mb-4">
                    <span class="text-muted text-uppercase text-xxs fw-bold d-block mb-1">Motivo / Asunto:</span>
                    <div class="p-3 border rounded-3 bg-white border-start border-primary border-4">
                        <h6 class="fw-bold text-dark mb-0 fs-6"><?= htmlspecialchars($contact['subject']) ?></h6>
                    </div>
                </div>

                <!-- Mensaje Completo -->
                <div class="mb-2">
                    <span class="text-muted text-uppercase text-xxs fw-bold d-block mb-1">Mensaje / Requerimiento:</span>
                    <div class="p-3 border rounded-3 bg-light text-dark text-xs" style="white-space: pre-wrap; line-height: 1.7;">
                        <?= htmlspecialchars($contact['message']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gestión y Seguimiento -->
    <div class="col-lg-4">
        <!-- Tarjeta de Estado y Notas -->
        <div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-gear-fill text-primary"></i>
                    <span>Gestión de Estado</span>
                </h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= ADMIN_URL ?>/?c=contact&a=view&id=<?= $contact['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="status" class="form-label text-xs fw-semibold text-muted text-uppercase">Estado del Mensaje</label>
                        <select class="form-select form-select-sm" id="status" name="status">
                            <option value="unread" <?= ($contact['status'] === 'unread') ? 'selected' : '' ?>>🔴 No Leído</option>
                            <option value="read" <?= ($contact['status'] === 'read') ? 'selected' : '' ?>>🔵 Leído (En Proceso)</option>
                            <option value="responded" <?= ($contact['status'] === 'responded') ? 'selected' : '' ?>>🟢 Respondido</option>
                            <option value="archived" <?= ($contact['status'] === 'archived') ? 'selected' : '' ?>>⚪ Archivado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label text-xs fw-semibold text-muted text-uppercase">Notas Internas</label>
                        <textarea class="form-control form-control-sm" id="admin_notes" name="admin_notes" rows="4" placeholder="Ej: Se contactó por llamada y se derivó con el ejecutivo técnico..."><?= htmlspecialchars($contact['admin_notes'] ?? '') ?></textarea>
                        <small class="text-muted text-xxs">Visible únicamente para el equipo administrativo.</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold d-flex align-items-center justify-content-center gap-1.5 py-2">
                        <i class="bi bi-save-fill"></i> Guardar Seguimiento
                    </button>
                </form>
            </div>
        </div>

        <!-- Canales de Respuesta Rápida -->
        <div class="card shadow-sm border-0 rounded-3 bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-reply-fill text-success"></i>
                    <span>Responder al Cliente</span>
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="d-grid gap-2">
                    <a href="mailto:<?= htmlspecialchars($contact['email']) ?>?subject=<?= urlencode('Respuesta VICTORQ: ' . $contact['subject']) ?>" class="btn btn-sm btn-outline-dark d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-envelope-fill text-primary"></i> Responder por Correo
                    </a>
                    <?php if (!empty($contact['phone'])): ?>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $contact['phone']) ?>?text=<?= urlencode('Hola ' . $contact['name'] . ', le contactamos de VICTORQ respecto a su consulta: ' . $contact['subject']) ?>" target="_blank" class="btn btn-sm btn-outline-success d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-whatsapp"></i> Contactar por WhatsApp
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
