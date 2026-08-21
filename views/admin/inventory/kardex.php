<?php
$pageTitle = 'Historial Kardex de Inventario';

$typeBadges = [
    'in' => '<span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-arrow-down-left me-1"></i>Ingreso (+)</span>',
    'sale' => '<span class="badge bg-primary-subtle text-primary border border-primary-subtle"><i class="bi bi-cart-check-fill me-1"></i>Venta Flow (-)</span>',
    'out' => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle"><i class="bi bi-arrow-up-right me-1"></i>Salida / Merma (-)</span>',
    'adjustment' => '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle"><i class="bi bi-arrow-left-right me-1"></i>Ajuste Físico (=)</span>',
];
?>
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-clock-history text-primary"></i>
            <span>Historial Kardex de Movimientos de Inventario</span>
        </h4>
        <p class="text-muted text-xs mb-0">Auditoría cronológica inmutable de todas las entradas, salidas, ventas en Flow y ajustes de bodega.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= ADMIN_URL ?>/?c=inventory" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 text-xs">
            <i class="bi bi-arrow-left"></i> Volver a Control de Stock
        </a>
    </div>
</div>

<!-- FILTROS DE KARDEX -->
<div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
    <div class="card-body p-3">
        <form action="<?= ADMIN_URL ?>/" method="GET" class="row g-2 align-items-center">
            <input type="hidden" name="c" value="inventory">
            <input type="hidden" name="a" value="kardex">

            <div class="col-md-5">
                <label for="filter_product" class="form-label text-xxs fw-bold text-muted text-uppercase mb-1">Filtrar por Equipo</label>
                <select class="form-select form-select-sm" id="filter_product" name="product_id">
                    <option value="">-- Todos los Equipos --</option>
                    <?php foreach ($products as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= ($selectedProduct == $p['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['model']) ?> — <?= htmlspecialchars($p['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label for="filter_type" class="form-label text-xxs fw-bold text-muted text-uppercase mb-1">Tipo de Movimiento</label>
                <select class="form-select form-select-sm" id="filter_type" name="type">
                    <option value="">-- Todos los Tipos --</option>
                    <option value="in" <?= ($selectedType === 'in') ? 'selected' : '' ?>>🟢 Ingreso / Recepción</option>
                    <option value="sale" <?= ($selectedType === 'sale') ? 'selected' : '' ?>>🔵 Venta Flow.cl</option>
                    <option value="out" <?= ($selectedType === 'out') ? 'selected' : '' ?>>🔴 Salida / Merma</option>
                    <option value="adjustment" <?= ($selectedType === 'adjustment') ? 'selected' : '' ?>>🟡 Ajuste Físico</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end gap-2 pt-3">
                <button type="submit" class="btn btn-sm btn-primary w-100 fw-bold">
                    <i class="bi bi-funnel-fill me-1"></i> Filtrar Kardex
                </button>
                <a href="<?= ADMIN_URL ?>/?c=inventory&a=kardex" class="btn btn-sm btn-outline-secondary" title="Limpiar Filtros">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- TABLA KARDEX -->
<div class="card shadow-sm border-0 rounded-3 bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-journal-text text-primary"></i>
            <span>Asientos Cronológicos de Inventario (Últimos <?= count($kardexRows) ?> registros)</span>
        </h6>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0 text-xs">
                <thead class="table-light text-uppercase text-xxs text-muted">
                    <tr>
                        <th class="ps-3" style="width: 50px;">#ID</th>
                        <th style="width: 130px;">Fecha y Hora</th>
                        <th style="width: 45px;">Foto</th>
                        <th>Equipo / Modelo</th>
                        <th class="text-center" style="width: 140px;">Tipo de Movimiento</th>
                        <th class="text-center" style="width: 80px;">Cantidad</th>
                        <th class="text-center" style="width: 130px;">Saldo Kardex</th>
                        <th>Referencia / Documento</th>
                        <th>Usuario / Responsable</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kardexRows)): ?>
                        <?php foreach ($kardexRows as $row): 
                            $qtyPrefix = in_array($row['type'], ['in']) ? '+' : (in_array($row['type'], ['out', 'sale']) ? '-' : '');
                            $qtyColor = in_array($row['type'], ['in']) ? 'text-success' : (in_array($row['type'], ['out', 'sale']) ? 'text-danger' : 'text-warning');
                        ?>
                            <tr>
                                <td class="ps-3 py-2.5 font-monospace fw-bold text-muted">#<?= $row['id'] ?></td>
                                <td class="text-muted">
                                    <span class="d-block fw-semibold text-dark"><?= date('d/m/Y', strtotime($row['created_at'])) ?></span>
                                    <span class="text-xxs"><?= date('H:i:s', strtotime($row['created_at'])) ?></span>
                                </td>
                                <td>
                                    <div style="width: 36px; height: 36px; border: 1px solid #e5e7eb; padding: 2px; display: flex; align-items: center; justify-content: center; background: #ffffff;">
                                        <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($row['product_image'] ?? 'default.png') ?>" alt="Foto" style="max-height: 100%; max-width: 100%; object-fit: contain;" onerror="this.src='<?= ASSETS_URL ?>/img/logo.png'">
                                    </div>
                                </td>
                                <td>
                                    <strong style="font-family: 'Montserrat', sans-serif; color: #015B91; text-transform: uppercase;">
                                        <?= htmlspecialchars($row['product_model'] ?? 'N/A') ?>
                                    </strong>
                                    <div class="text-dark fw-bold"><?= htmlspecialchars($row['product_name'] ?? 'Producto Desconocido') ?></div>
                                </td>
                                <td class="text-center">
                                    <?= $typeBadges[$row['type']] ?? '<span class="badge bg-secondary">Ajuste</span>' ?>
                                </td>
                                <td class="text-center font-monospace fw-bold <?= $qtyColor ?>" style="font-size: 0.85rem;">
                                    <?= $qtyPrefix ?><?= (int)$row['quantity'] ?>
                                </td>
                                <td class="text-center font-monospace">
                                    <span class="text-muted"><?= $row['previous_stock'] ?></span>
                                    <i class="bi bi-arrow-right text-secondary mx-1"></i>
                                    <strong class="text-dark fs-6"><?= $row['new_stock'] ?></strong>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark"><?= htmlspecialchars($row['reference'] ?: 'Sin referencia') ?></span>
                                    <?php if (!empty($row['notes'])): ?>
                                        <div class="text-muted text-xxs"><?= htmlspecialchars($row['notes']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-person-fill text-secondary me-1"></i>
                                        <?= htmlspecialchars($row['user_name'] ?: 'Sistema Automático') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-clock-history fs-2 d-block mb-2 text-secondary"></i>
                                No se encontraron registros de Kardex con los filtros aplicados.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
