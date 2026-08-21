<?php
$pageTitle = 'Control de Inventario y Existencias';
?>
<!-- KPI METRIC CARDS -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card shadow-sm border-0 rounded-3 bg-white p-3 border-start border-primary border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-xs text-muted text-uppercase fw-bold">Unidades en Bodega</span>
                    <h3 class="fw-bold text-dark mb-0 fs-4"><?= number_format($kpis['total_units'], 0, ',', '.') ?></h3>
                    <small class="text-primary fw-semibold text-xxs">Valorizado: $<?= number_format($kpis['total_valuation'], 0, ',', '.') ?> CLP</small>
                </div>
                <div class="avatar-circle bg-primary-subtle text-primary">
                    <i class="bi bi-boxes fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card shadow-sm border-0 rounded-3 bg-white p-3 border-start border-warning border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-xs text-muted text-uppercase fw-bold">Stock Crítico (Reponer)</span>
                    <h3 class="fw-bold text-warning-emphasis mb-0 fs-4"><?= $kpis['critical_count'] ?></h3>
                    <small class="text-muted text-xxs">&le; Stock mínimo de seguridad</small>
                </div>
                <div class="avatar-circle bg-warning-subtle text-warning-emphasis">
                    <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card shadow-sm border-0 rounded-3 bg-white p-3 border-start border-danger border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-xs text-muted text-uppercase fw-bold">Equipos Agotados</span>
                    <h3 class="fw-bold text-danger mb-0 fs-4"><?= $kpis['out_of_stock_count'] ?></h3>
                    <small class="text-danger text-xxs">Sin existencias disponibles</small>
                </div>
                <div class="avatar-circle bg-danger-subtle text-danger">
                    <i class="bi bi-x-circle-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card shadow-sm border-0 rounded-3 bg-white p-3 border-start border-info border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-xs text-muted text-uppercase fw-bold">Movimientos del Mes</span>
                    <h3 class="fw-bold text-info-emphasis mb-0 fs-4"><?= $kpis['month_movements'] ?></h3>
                    <small class="text-muted text-xxs">Ventas, ingresos y ajustes</small>
                </div>
                <div class="avatar-circle bg-info-subtle text-info-emphasis">
                    <i class="bi bi-journal-text fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- INVENTORY CONTROL CARD -->
<div class="card shadow-sm border-0 rounded-3 bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-building text-primary"></i>
                <span>Existencias en Bodega Central</span>
            </h6>
            <span class="badge bg-secondary-subtle text-secondary"><?= count($items) ?> equipos</span>
        </div>

        <div class="d-flex align-items-center gap-2 flex-nowrap">
            <!-- Filter Tabs -->
            <div class="btn-group btn-group-sm">
                <a href="<?= ADMIN_URL ?>/?c=inventory&filter=all" class="btn btn-outline-secondary <?= ($selectedFilter === 'all' || empty($selectedFilter)) ? 'active' : '' ?>">Todos</a>
                <a href="<?= ADMIN_URL ?>/?c=inventory&filter=optimal" class="btn btn-outline-success <?= ($selectedFilter === 'optimal') ? 'active' : '' ?>">Óptimos</a>
                <a href="<?= ADMIN_URL ?>/?c=inventory&filter=critical" class="btn btn-outline-warning <?= ($selectedFilter === 'critical') ? 'active' : '' ?>">Críticos</a>
                <a href="<?= ADMIN_URL ?>/?c=inventory&filter=out_of_stock" class="btn btn-outline-danger <?= ($selectedFilter === 'out_of_stock') ? 'active' : '' ?>">Agotados</a>
            </div>

            <!-- Search -->
            <div class="input-group input-group-sm" style="width: 170px;">
                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                <input type="text" id="inventorySearch" class="form-control" placeholder="Buscar equipo...">
            </div>

            <!-- Action Buttons -->
            <button type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1.5 text-xs fw-bold text-nowrap" data-bs-toggle="modal" data-bs-target="#modalAjusteStock">
                <i class="bi bi-plus-slash-minus"></i>
                <span>Ajustar</span>
            </button>

            <a href="<?= ADMIN_URL ?>/?c=inventory&a=kardex" class="btn btn-sm btn-outline-dark d-inline-flex align-items-center gap-1 text-xs text-nowrap">
                <i class="bi bi-clock-history"></i>
                <span>Kardex</span>
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0 text-xs" id="inventoryTable">
                <thead class="table-light text-uppercase text-xxs text-muted">
                    <tr>
                        <th class="ps-3" style="width: 48px;">Foto</th>
                        <th>Modelo / SKU</th>
                        <th>Nombre del Equipo</th>
                        <th>Categoría</th>
                        <th>Ubicación Bodega</th>
                        <th class="text-center" style="width: 100px;">Stock Actual</th>
                        <th class="text-center" style="width: 80px;">Mínimo</th>
                        <th class="text-end" style="width: 110px;">P. Unitario</th>
                        <th class="text-end" style="width: 125px;">Valor Total</th>
                        <th class="text-end pe-3" style="width: 80px;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): 
                            $status = $item['stock_status'];
                        ?>
                            <tr>
                                <td class="ps-3 py-2">
                                    <div style="width: 40px; height: 40px; border: 1px solid #e5e7eb; padding: 2px; display: flex; align-items: center; justify-content: center; background: #ffffff;">
                                        <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($item['image']) ?>" alt="Foto" style="max-height: 100%; max-width: 100%; object-fit: contain;" onerror="this.src='<?= ASSETS_URL ?>/img/logo.png'">
                                    </div>
                                </td>
                                <td>
                                    <strong style="font-family: 'Montserrat', sans-serif; color: #015B91; text-transform: uppercase;">
                                        <?= htmlspecialchars($item['model']) ?>
                                    </strong>
                                    <?php if (!empty($item['sku'])): ?>
                                        <div class="text-muted text-xxs font-monospace">SKU: <?= htmlspecialchars($item['sku']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark"><?= htmlspecialchars($item['name']) ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border"><?= htmlspecialchars($item['category_name'] ?? 'General') ?></span>
                                </td>
                                <td>
                                    <span class="text-muted text-xxs"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($item['warehouse_location'] ?: 'Bodega Central') ?></span>
                                </td>
                                <td class="text-center font-monospace">
                                    <?php if ($status === 'out_of_stock'): ?>
                                        <span class="badge bg-danger text-white px-2 py-1 fs-6">0</span>
                                    <?php elseif ($status === 'critical'): ?>
                                        <span class="badge bg-warning text-dark px-2 py-1 fs-6"><?= $item['stock'] ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-6"><?= $item['stock'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center font-monospace text-muted"><?= (int)$item['min_stock'] ?></td>
                                <td class="text-end font-monospace">$<?= number_format((float)$item['price'], 0, ',', '.') ?></td>
                                <td class="text-end font-monospace fw-bold text-primary">$<?= number_format((float)$item['total_valuation'], 0, ',', '.') ?></td>
                                <td class="text-end pe-3">
                                    <button type="button" class="btn btn-xs btn-outline-primary btn-quick-adjust" 
                                            data-id="<?= $item['id'] ?>" 
                                            data-model="<?= htmlspecialchars($item['model']) ?>" 
                                            data-name="<?= htmlspecialchars($item['name']) ?>" 
                                            data-stock="<?= $item['stock'] ?>" 
                                            title="Registrar Movimiento">
                                        <i class="bi bi-arrow-left-right"></i> Ajustar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">No se encontraron productos con el filtro de inventario seleccionado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL DE AJUSTE / MOVIMIENTO DE STOCK -->
<div class="modal fade" id="modalAjusteStock" tabindex="-1" aria-labelledby="modalAjusteStockLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white py-3 border-bottom border-primary border-3">
                <h5 class="modal-title fw-bold text-uppercase d-flex align-items-center gap-2 fs-6" id="modalAjusteStockLabel">
                    <i class="bi bi-boxes text-primary"></i>
                    <span>Registrar Movimiento de Inventario</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= ADMIN_URL ?>/?c=inventory&a=adjust" method="POST" id="form-ajuste-stock">
                <div class="modal-body p-4 bg-white">
                    <div class="mb-3">
                        <label for="modal_product_id" class="form-label text-xs fw-bold text-muted text-uppercase">Equipo / Producto *</label>
                        <select class="form-select form-select-sm" id="modal_product_id" name="product_id" required>
                            <option value="">-- Seleccionar Equipo --</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?= $p['id'] ?>" data-stock="<?= (int)($p['stock'] ?? 0) ?>">
                                    <?= htmlspecialchars($p['model']) ?> — <?= htmlspecialchars($p['name']) ?> (Stock actual: <?= (int)($p['stock'] ?? 0) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label for="modal_type" class="form-label text-xs fw-bold text-muted text-uppercase">Tipo de Movimiento *</label>
                            <select class="form-select form-select-sm" id="modal_type" name="type" required>
                                <option value="in">🟢 Ingreso / Recepción (+)</option>
                                <option value="out">🔴 Salida / Merma (-)</option>
                                <option value="adjustment">🟡 Cuadratura Física (=)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_quantity" class="form-label text-xs fw-bold text-muted text-uppercase">Cantidad *</label>
                            <input type="number" class="form-control form-control-sm font-monospace text-center fw-bold" id="modal_quantity" name="quantity" value="1" min="0" max="9999" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modal_reference" class="form-label text-xs fw-bold text-muted text-uppercase">Documento de Referencia</label>
                        <input type="text" class="form-control form-control-sm" id="modal_reference" name="reference" placeholder="Ej: Guía de Despacho #8492 / O.C. Proveedor #104">
                    </div>

                    <div class="mb-0">
                        <label for="modal_notes" class="form-label text-xs fw-bold text-muted text-uppercase">Observaciones / Motivo</label>
                        <textarea class="form-control form-control-sm" id="modal_notes" name="notes" rows="2" placeholder="Motivo del ingreso o merma..."></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light py-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-primary px-4 fw-bold">
                        <i class="bi bi-save me-1"></i> Confirmar Asiento Kardex
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Buscador predictivo
    document.getElementById('inventorySearch')?.addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#inventoryTable tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Botones de ajuste rápido en cada fila
    const modalEl = document.getElementById('modalAjusteStock');
    const selectProd = document.getElementById('modal_product_id');

    document.querySelectorAll('.btn-quick-adjust').forEach(btn => {
        btn.addEventListener('click', function() {
            const pId = this.getAttribute('data-id');
            if (selectProd) {
                selectProd.value = pId;
            }
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        });
    });
});
</script>
