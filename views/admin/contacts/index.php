<?php
$pageTitle = 'Mensajes de Contacto Web';
$statusBadges = [
    'unread' => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle"><i class="bi bi-envelope-fill me-1"></i>No Leído</span>',
    'read' => '<span class="badge bg-info-subtle text-info-emphasis border border-info-subtle"><i class="bi bi-envelope-open me-1"></i>Leído</span>',
    'responded' => '<span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle-fill me-1"></i>Respondido</span>',
    'archived' => '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle"><i class="bi bi-archive me-1"></i>Archivado</span>',
];
?>
<!-- STATUS FILTER TABS -->
<div class="row g-2 mb-3">
    <div class="col-6 col-md-3">
        <a href="<?= ADMIN_URL ?>/?c=contact&status=all" class="text-decoration-none">
            <div class="card shadow-xs border-0 rounded-2 p-2 bg-white text-center <?= ($selectedStatus === 'all' || empty($selectedStatus)) ? 'border-primary border-2' : '' ?>">
                <span class="text-xs text-muted">Todos los Mensajes</span>
                <div class="fw-bold text-dark fs-6"><?= $counts['total'] ?? 0 ?></div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="<?= ADMIN_URL ?>/?c=contact&status=unread" class="text-decoration-none">
            <div class="card shadow-xs border-0 rounded-2 p-2 bg-white text-center <?= ($selectedStatus === 'unread') ? 'border-danger border-2' : '' ?>">
                <span class="text-xs text-danger fw-semibold">No Leídos (Nuevos)</span>
                <div class="fw-bold text-danger fs-6"><?= $counts['unread'] ?? 0 ?></div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="<?= ADMIN_URL ?>/?c=contact&status=responded" class="text-decoration-none">
            <div class="card shadow-xs border-0 rounded-2 p-2 bg-white text-center <?= ($selectedStatus === 'responded') ? 'border-success border-2' : '' ?>">
                <span class="text-xs text-success fw-semibold">Respondidos</span>
                <div class="fw-bold text-success fs-6"><?= $counts['responded'] ?? 0 ?></div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="<?= ADMIN_URL ?>/?c=contact&status=archived" class="text-decoration-none">
            <div class="card shadow-xs border-0 rounded-2 p-2 bg-white text-center <?= ($selectedStatus === 'archived') ? 'border-secondary border-2' : '' ?>">
                <span class="text-xs text-secondary fw-semibold">Archivados</span>
                <div class="fw-bold text-secondary fs-6"><?= $counts['archived'] ?? 0 ?></div>
            </div>
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3 bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <h6 class="mb-0 fw-bold text-dark d-flex align-items-center"><i class="bi bi-envelope-paper text-primary me-2"></i>Mensajes Recibidos desde la Web</h6>
            <span class="badge bg-secondary-subtle text-secondary"><?= count($contacts) ?> registros</span>
        </div>

        <div class="d-flex align-items-center gap-2 flex-nowrap">
            <div class="input-group input-group-sm" style="width: 240px;">
                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                <input type="text" id="contactSearch" class="form-control" placeholder="Buscar por nombre, empresa...">
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0 text-xs" id="contactTable">
                <thead class="table-light text-uppercase text-xxs text-muted">
                    <tr>
                        <th class="ps-3" style="width: 50px;">#ID</th>
                        <th>Contacto / Solicitante</th>
                        <th>Empresa / RUT</th>
                        <th>Asunto / Requerimiento</th>
                        <th>Fecha de Recepción</th>
                        <th class="text-center">Estado</th>
                        <th class="text-end pe-3" style="width: 110px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($contacts)): ?>
                        <?php foreach ($contacts as $c): 
                            $isUnread = $c['status'] === 'unread';
                        ?>
                        <tr class="<?= $isUnread ? 'table-warning fw-semibold' : '' ?>">
                            <td class="ps-3 py-2.5 fw-bold <?= $isUnread ? 'text-danger' : 'text-muted' ?>">
                                #<?= $c['id'] ?>
                                <?php if ($isUnread): ?>
                                    <span class="badge bg-danger p-1 rounded-circle d-inline-block" style="width: 6px; height: 6px;"></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($c['name']) ?></div>
                                <div class="text-muted text-xxs d-flex gap-2">
                                    <span><i class="bi bi-envelope"></i> <?= htmlspecialchars($c['email']) ?></span>
                                    <span><i class="bi bi-telephone"></i> <?= htmlspecialchars($c['phone']) ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark"><?= htmlspecialchars($c['company']) ?></div>
                                <?php if (!empty($c['rut'])): ?>
                                    <small class="text-muted text-xxs font-monospace">RUT: <?= htmlspecialchars($c['rut']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-primary"><?= htmlspecialchars($c['subject']) ?></div>
                                <div class="text-muted text-xxs text-truncate max-w-250"><?= htmlspecialchars(substr($c['message'], 0, 80)) ?>...</div>
                            </td>
                            <td class="text-muted">
                                <div><?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></div>
                            </td>
                            <td class="text-center">
                                <?= $statusBadges[$c['status']] ?? '<span class="badge bg-secondary">N/A</span>' ?>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= ADMIN_URL ?>/?c=contact&a=view&id=<?= $c['id'] ?>" class="btn btn-xs btn-outline-primary" title="Ver Mensaje y Responder">
                                        <i class="bi bi-eye"></i> Detalle
                                    </a>
                                    <?php if (Auth::can('contacts', 'delete')): ?>
                                        <a href="<?= ADMIN_URL ?>/?c=contact&a=delete&id=<?= $c['id'] ?>" class="btn btn-xs btn-outline-secondary btn-delete" data-name="Mensaje #<?= $c['id'] ?>" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                No se encontraron mensajes de contacto con el filtro seleccionado.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('contactSearch')?.addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#contactTable tbody tr');
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>
