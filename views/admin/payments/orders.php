<?php
/**
 * Vista de Órdenes y Transacciones Flow.cl (Admin)
 */
?>
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-receipt text-primary"></i>
            <span>Órdenes y Transacciones Flow.cl</span>
        </h4>
        <p class="text-muted text-xs mb-0">Historial completo de pagos procesados mediante Flow (Webpay, Servipag, tarjetas y transferencias).</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= ADMIN_URL ?>/?c=payment_config" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1.5 text-xs">
            <i class="bi bi-gear-fill"></i>
            <span>Configurar Pasarela</span>
        </a>
    </div>
</div>

<!-- Filtros de Estado -->
<div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
    <div class="card-body p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="text-xs fw-bold text-muted text-uppercase me-1">Filtrar por Estado:</span>
            <a href="<?= ADMIN_URL ?>/?c=payment_config&a=orders&status=all" class="btn btn-xs <?= ($selectedStatus === 'all' || empty($selectedStatus)) ? 'btn-dark' : 'btn-outline-secondary' ?>">Todas</a>
            <a href="<?= ADMIN_URL ?>/?c=payment_config&a=orders&status=paid" class="btn btn-xs <?= ($selectedStatus === 'paid') ? 'btn-success' : 'btn-outline-success' ?>">Pagadas</a>
            <a href="<?= ADMIN_URL ?>/?c=payment_config&a=orders&status=pending" class="btn btn-xs <?= ($selectedStatus === 'pending') ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' ?>">Pendientes</a>
            <a href="<?= ADMIN_URL ?>/?c=payment_config&a=orders&status=rejected" class="btn btn-xs <?= ($selectedStatus === 'rejected') ? 'btn-danger' : 'btn-outline-danger' ?>">Rechazadas</a>
            <a href="<?= ADMIN_URL ?>/?c=payment_config&a=orders&status=canceled" class="btn btn-xs <?= ($selectedStatus === 'canceled') ? 'btn-secondary' : 'btn-outline-secondary' ?>">Anuladas</a>
        </div>
        <div class="text-xs text-muted fw-semibold">
            Total: <?= count($orders) ?> transacciones
        </div>
    </div>
</div>

<!-- Tabla de Transacciones -->
<div class="card shadow-sm border-0 rounded-3 bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-xs">
                <thead class="table-light border-bottom">
                    <tr>
                        <th class="ps-3 py-3 text-uppercase text-xxs fw-bold text-muted">N° Orden</th>
                        <th class="py-3 text-uppercase text-xxs fw-bold text-muted">N° Flow</th>
                        <th class="py-3 text-uppercase text-xxs fw-bold text-muted">Equipo / Concepto</th>
                        <th class="py-3 text-uppercase text-xxs fw-bold text-muted">Cliente / Pagador</th>
                        <th class="py-3 text-uppercase text-xxs fw-bold text-muted text-end">Monto</th>
                        <th class="py-3 text-uppercase text-xxs fw-bold text-muted text-center">Estado</th>
                        <th class="py-3 text-uppercase text-xxs fw-bold text-muted">Fecha</th>
                        <th class="pe-3 py-3 text-uppercase text-xxs fw-bold text-muted text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $ord): ?>
                            <tr>
                                <td class="ps-3 font-monospace fw-bold text-dark">
                                    <?= htmlspecialchars($ord['commerce_order']) ?>
                                </td>
                                <td class="font-monospace text-muted">
                                    <?= htmlspecialchars($ord['flow_order'] ?: '—') ?>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($ord['product_name']) ?></div>
                                    <?php if (!empty($ord['product_id'])): ?>
                                        <small class="text-muted text-xxs">ID Producto: #<?= $ord['product_id'] ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= htmlspecialchars($ord['customer_name']) ?></div>
                                    <div class="text-muted text-xxs"><?= htmlspecialchars($ord['customer_email']) ?></div>
                                    <?php if (!empty($ord['customer_phone'])): ?>
                                        <div class="text-muted text-xxs"><?= htmlspecialchars($ord['customer_phone']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end font-monospace fw-bold text-dark">
                                    $<?= number_format((float)$ord['amount'], 0, ',', '.') ?> <?= htmlspecialchars($ord['currency']) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($ord['status'] === 'paid'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="bi bi-check-circle-fill me-1"></i> Pagada
                                        </span>
                                    <?php elseif ($ord['status'] === 'pending'): ?>
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                            <i class="bi bi-hourglass-split me-1"></i> Pendiente
                                        </span>
                                    <?php elseif ($ord['status'] === 'rejected'): ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                            <i class="bi bi-x-circle-fill me-1"></i> Rechazada
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">
                                            <?= ucfirst($ord['status']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted text-xxs">
                                    <?= date('d/m/Y H:i', strtotime($ord['created_at'])) ?>
                                </td>
                                <td class="text-end pe-3">
                                    <button type="button" class="btn btn-xs btn-outline-info btn-view-order" data-id="<?= $ord['id'] ?>" title="Ver Detalles de la Transacción">
                                        <i class="bi bi-eye"></i> Detalle
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-receipt fs-2 d-block mb-2 text-secondary"></i>
                                No se registran transacciones con el filtro seleccionado.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detalle de Transacción -->
<div class="modal fade" id="modalOrderDetails" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white py-3">
                <h6 class="modal-title fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-receipt-cutoff text-warning"></i>
                    <span>Detalle de Transacción Flow.cl</span>
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modal-order-content">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('modalOrderDetails');
    const modalContent = document.getElementById('modal-order-content');
    const bsModal = new bootstrap.Modal(modalEl);

    document.querySelectorAll('.btn-view-order').forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-id');
            modalContent.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';
            bsModal.show();

            fetch('<?= ADMIN_URL ?>/?c=payment_config&a=viewOrder&id=' + orderId)
                .then(res => res.json())
                .then(res => {
                    if (!res.success) {
                        modalContent.innerHTML = '<div class="alert alert-danger">' + res.message + '</div>';
                        return;
                    }

                    const o = res.order;
                    const pData = o.payment_data_parsed || {};

                    let statusBadge = '';
                    if (o.status === 'paid') {
                        statusBadge = '<span class="badge bg-success">PAGADA (Aprobada)</span>';
                    } else if (o.status === 'pending') {
                        statusBadge = '<span class="badge bg-warning text-dark">PENDIENTE</span>';
                    } else {
                        statusBadge = '<span class="badge bg-danger">RECHAZADA / ANULADA</span>';
                    }

                    modalContent.innerHTML = `
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-xxs text-uppercase text-muted fw-bold">Orden Comercio:</label>
                                <div class="font-monospace fw-bold fs-6 text-dark">${o.commerce_order}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-xxs text-uppercase text-muted fw-bold">N° Flow Order:</label>
                                <div class="font-monospace fw-bold fs-6 text-primary">${o.flow_order || '—'}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-xxs text-uppercase text-muted fw-bold">Estado:</label>
                                <div>${statusBadge}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-xxs text-uppercase text-muted fw-bold">Monto:</label>
                                <div class="font-monospace fw-bold text-dark fs-6">$${Number(o.amount).toLocaleString('es-CL')} ${o.currency}</div>
                            </div>

                            <div class="col-12 border-top pt-2">
                                <h6 class="text-xs fw-bold text-dark text-uppercase mb-2">Datos del Cliente</h6>
                                <div class="p-3 bg-light rounded text-xs">
                                    <div><strong>Nombre:</strong> ${o.customer_name}</div>
                                    <div><strong>Email:</strong> ${o.customer_email}</div>
                                    <div><strong>Teléfono:</strong> ${o.customer_phone || 'No registrado'}</div>
                                </div>
                            </div>

                            <div class="col-12 border-top pt-2">
                                <h6 class="text-xs fw-bold text-dark text-uppercase mb-2">Equipo / Ítem</h6>
                                <div class="p-3 bg-light rounded text-xs">
                                    <div><strong>Descripción:</strong> ${o.product_name}</div>
                                </div>
                            </div>

                            ${o.flow_token ? `
                            <div class="col-12 border-top pt-2">
                                <label class="text-xxs text-uppercase text-muted fw-bold">Token Flow:</label>
                                <div class="p-2 bg-light font-monospace text-xxs text-break">${o.flow_token}</div>
                            </div>
                            ` : ''}

                            ${Object.keys(pData).length > 0 ? `
                            <div class="col-12 border-top pt-2">
                                <h6 class="text-xs fw-bold text-dark text-uppercase mb-2">Respuesta Técnica de Flow (Metadata)</h6>
                                <pre class="bg-dark text-light p-3 rounded text-xxs mb-0" style="max-height: 180px; overflow-y: auto;">${JSON.stringify(pData, null, 2)}</pre>
                            </div>
                            ` : ''}
                        </div>
                    `;
                })
                .catch(err => {
                    modalContent.innerHTML = '<div class="alert alert-danger">Error al obtener los detalles de la orden.</div>';
                });
        });
    });
});
</script>
