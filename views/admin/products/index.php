<?php
$pageTitle = 'Gestión de Productos';
?>
<div class="card shadow-sm border-0 rounded-3 bg-white">
    <!-- Card Header & Filters (Una sola línea ordenada) -->
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <h6 class="mb-0 fw-bold text-dark d-flex align-items-center"><i class="bi bi-box-seam text-primary me-2"></i>Catálogo de Productos</h6>
            <span class="badge bg-secondary-subtle text-secondary"><?= count($products) ?> items</span>
        </div>

        <div class="d-flex align-items-center gap-2 flex-nowrap">
            <!-- Category Filter Dropdown -->
            <form action="<?= ADMIN_URL ?>/" method="GET" class="d-inline-flex m-0">
                <input type="hidden" name="c" value="product">
                <select name="category_id" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 170px;">
                    <option value="0">Todas las categorías</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($selectedCategory == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <!-- Search input -->
            <div class="input-group input-group-sm" style="width: 170px;">
                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                <input type="text" id="productSearch" class="form-control" placeholder="Buscar producto...">
            </div>

            <!-- Create Button -->
            <?php if (Auth::can('products', 'create')): ?>
                <a href="<?= ADMIN_URL ?>/?c=product&a=create" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1.5 fw-bold text-nowrap">
                    <i class="bi bi-plus-lg"></i> <span>Nuevo</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Table -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0 text-xs" id="productTable">
                <thead class="table-light text-uppercase text-xxs text-muted">
                    <tr>
                        <th class="ps-3" style="width: 60px;">Foto</th>
                        <th>Modelo</th>
                        <th>Nombre del Producto</th>
                        <th>Categoría</th>
                        <th>Especificaciones Principales</th>
                        <th class="text-center">Estado</th>
                        <th class="text-end pe-3" style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $p): 
                            $specs = json_decode($p['specs_json'] ?? '{}', true) ?: [];
                        ?>
                        <tr>
                            <td class="ps-3 py-2">
                                <div class="table-prod-thumb">
                                    <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" onerror="this.src='<?= ASSETS_URL ?>/img/logo.png'">
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-primary"><?= htmlspecialchars($p['model']) ?></span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark"><?= htmlspecialchars($p['name']) ?></div>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <small class="text-muted text-xxs">Orden: #<?= $p['sort_order'] ?></small>
                                    <?php if (!empty($p['datasheet_pdf'])): ?>
                                        <a href="<?= ASSETS_URL ?>/docs/datasheets/<?= htmlspecialchars($p['datasheet_pdf']) ?>" target="_blank" class="badge bg-danger-subtle text-danger border border-danger-subtle text-xxs text-decoration-none" title="Ver Ficha Técnica PDF">
                                            <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-dark-subtle text-dark border"><?= htmlspecialchars($p['category_name'] ?? 'General') ?></span>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1 max-w-350">
                                    <?php $cnt = 0; foreach ($specs as $k => $v): if ($cnt++ >= 3) break; ?>
                                        <span class="badge bg-light text-secondary border text-xxs"><?= htmlspecialchars($k) ?>: <strong><?= htmlspecialchars($v) ?></strong></span>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <?php if ($p['is_active']): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= BASE_URL ?>/product.php?id=<?= $p['id'] ?>" target="_blank" class="btn btn-xs btn-outline-info" title="Ver Ficha Web Pública">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                    <?php if (Auth::can('products', 'edit')): ?>
                                        <a href="<?= ADMIN_URL ?>/?c=product&a=toggle&id=<?= $p['id'] ?>" class="btn btn-xs btn-outline-secondary" title="Cambiar Estado">
                                            <i class="bi <?= $p['is_active'] ? 'bi-toggle-on text-success' : 'bi-toggle-off text-muted' ?>"></i>
                                        </a>
                                        <a href="<?= ADMIN_URL ?>/?c=product&a=edit&id=<?= $p['id'] ?>" class="btn btn-xs btn-outline-primary" title="Editar Producto">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (Auth::can('products', 'delete')): ?>
                                        <a href="<?= ADMIN_URL ?>/?c=product&a=delete&id=<?= $p['id'] ?>" class="btn btn-xs btn-outline-danger btn-delete" data-name="<?= htmlspecialchars($p['name']) ?>" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No se encontraron productos registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('productSearch')?.addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#productTable tbody tr');
    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>
