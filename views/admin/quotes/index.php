<?php
$pageTitle = 'Gestión de Cotizaciones';
$statusBadges = [
    'pending' => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle"><i class="bi bi-clock me-1"></i>Pendiente</span>',
    'in_review' => '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle"><i class="bi bi-search me-1"></i>En Revisión</span>',
    'quoted' => '<span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle me-1"></i>Cotizado</span>',
    'closed' => '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle"><i class="bi bi-x-circle me-1"></i>Cerrado</span>',
];
?>
<!-- STATUS FILTER TABS -->
<div class="row g-2 mb-3">
    <div class="col-6 col-md-3">
        <div class="card shadow-xs border-0 rounded-2 p-2 bg-white text-center cursor-pointer status-filter" data-status="all">
            <span class="text-xs text-muted">Todas</span>
            <div class="fw-bold text-dark fs-6"><?= $counts['total'] ?? 0 ?></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-xs border-0 rounded-2 p-2 bg-white text-center cursor-pointer status-filter" data-status="pending">
            <span class="text-xs text-danger fw-semibold">Pendientes</span>
            <div class="fw-bold text-danger fs-6"><?= $counts['pending'] ?? 0 ?></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-xs border-0 rounded-2 p-2 bg-white text-center cursor-pointer status-filter" data-status="in_review">
            <span class="text-xs text-warning fw-semibold">En Revisión</span>
            <div class="fw-bold text-warning-emphasis fs-6"><?= $counts['in_review'] ?? 0 ?></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-xs border-0 rounded-2 p-2 bg-white text-center cursor-pointer status-filter" data-status="quoted">
            <span class="text-xs text-success fw-semibold">Cotizadas</span>
            <div class="fw-bold text-success fs-6"><?= $counts['quoted'] ?? 0 ?></div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3 bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
        <div class="d-flex align-items-center gap-2">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-text text-primary me-2"></i>Solicitudes de Cotización</h6>
            <span class="badge bg-secondary-subtle text-secondary"><?= count($quotes) ?> registros</span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="input-group input-group-sm" style="max-width: 250px;">
                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                <input type="text" id="quoteSearch" class="form-control" placeholder="Buscar cliente, empresa...">
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0 text-xs" id="quoteTable">
                <thead class="table-light text-uppercase text-xxs text-muted">
                    <tr>
                        <th class="ps-3" style="width: 50px;">#ID</th>
                        <th>Cliente / Contacto</th>
                        <th>Empresa</th>
                        <th>Interés / Producto</th>
                        <th>Fecha de Solicitud</th>
                        <th class="text-center">Estado</th>
                        <th class="text-end pe-3" style="width: 100px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($quotes)): ?>
                        <?php foreach ($quotes as $q): ?>
                        <tr data-status="<?= $q['status'] ?>">
                            <td class="ps-3 py-2.5 fw-bold text-muted">#<?= $q['id'] ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($q['client_name']) ?></div>
                                <div class="text-muted text-xxs d-flex gap-2">
                                    <span><i class="bi bi-envelope"></i> <?= htmlspecialchars($q['client_email']) ?></span>
                                    <?php if (!empty($q['client_phone'])): ?>
                                        <span><i class="bi bi-telephone"></i> <?= htmlspecialchars($q['client_phone']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark"><?= htmlspecialchars($q['company'] ?: 'Particular') ?></span>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block max-w-250 fw-medium text-primary" title="<?= htmlspecialchars($q['product_interest'] ?? '') ?>">
                                    <?= htmlspecialchars($q['product_interest'] ?: ($q['product_name'] ?? 'Consulta General')) ?>
                                </span>
                            </td>
                            <td class="text-muted">
                                <div><?= date('d/m/Y H:i', strtotime($q['created_at'])) ?></div>
                            </td>
                            <td class="text-center">
                                <?= $statusBadges[$q['status']] ?? '<span class="badge bg-secondary">N/A</span>' ?>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= ADMIN_URL ?>/?c=quote&a=view&id=<?= $q['id'] ?>" class="btn btn-xs btn-outline-primary" title="Ver Detalle y Responder">
                                        <i class="bi bi-eye"></i> Detalle
                                    </a>
                                    <?php if (Auth::can('quotes', 'delete')): ?>
                                        <a href="<?= ADMIN_URL ?>/?c=quote&a=delete&id=<?= $q['id'] ?>" class="btn btn-xs btn-outline-danger btn-delete" data-name="Cotización #<?= $q['id'] ?>" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No se encontraron cotizaciones registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('quoteSearch')?.addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#quoteTable tbody tr');
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});

document.querySelectorAll('.status-filter').forEach(card => {
    card.addEventListener('click', function() {
        let status = this.dataset.status;
        let rows = document.querySelectorAll('#quoteTable tbody tr');
        rows.forEach(row => {
            if (status === 'all' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
