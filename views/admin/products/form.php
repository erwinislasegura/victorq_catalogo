<?php
$pageTitle = $isEdit ? 'Editar Producto' : 'Nuevo Producto';
$specs = [];
if (!empty($product['specs_json'])) {
    if (is_array($product['specs_json'])) {
        $specs = $product['specs_json'];
    } else {
        $specs = json_decode($product['specs_json'], true) ?: [];
    }
}
?>
<div class="card shadow-sm border-0 rounded-3 bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi <?= $isEdit ? 'bi-pencil-square text-primary' : 'bi-plus-circle text-success' ?>"></i>
            <span><?= $pageTitle ?></span>
        </h6>
        <div class="d-flex align-items-center gap-2">
            <?php if ($isEdit && !empty($product['id'])): ?>
                <a href="<?= BASE_URL ?>/product.php?id=<?= (int)$product['id'] ?>" target="_blank" class="btn btn-sm btn-outline-info d-flex align-items-center gap-1 text-xs">
                    <i class="bi bi-box-arrow-up-right"></i> <span>Ver Ficha Pública</span>
                </a>
            <?php endif; ?>
            <a href="<?= ADMIN_URL ?>/?c=product" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 text-xs">
                <i class="bi bi-arrow-left"></i> <span>Volver a Productos</span>
            </a>
        </div>
    </div>

    <div class="card-body p-4">
        <form action="<?= ADMIN_URL ?>/?c=product&a=<?= $isEdit ? 'edit&id=' . $product['id'] : 'create' ?>" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <!-- Categoría -->
                <div class="col-md-4">
                    <label for="category_id" class="form-label text-xs fw-semibold text-muted text-uppercase">Categoría *</label>
                    <select class="form-select form-select-sm" id="category_id" name="category_id" required>
                        <option value="">Seleccione Categoría...</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (($product['category_id'] ?? 0) == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Modelo -->
                <div class="col-md-4">
                    <label for="model" class="form-label text-xs fw-semibold text-muted text-uppercase">Modelo / Serie *</label>
                    <input type="text" class="form-control form-control-sm" id="model" name="model" value="<?= htmlspecialchars($product['model'] ?? '') ?>" required placeholder="Ej: Serie MXTA">
                </div>

                <!-- Nombre -->
                <div class="col-md-4">
                    <label for="name" class="form-label text-xs fw-semibold text-muted text-uppercase">Nombre del Equipo *</label>
                    <input type="text" class="form-control form-control-sm" id="name" name="name" value="<?= htmlspecialchars($product['name'] ?? '') ?>" required placeholder="Ej: Llave de Torque Hidráulica de Cuadrante">
                </div>

                <!-- Descripción -->
                <div class="col-md-8">
                    <label for="description" class="form-label text-xs fw-semibold text-muted text-uppercase">Descripción / Resumen Técnico</label>
                    <textarea class="form-control form-control-sm" id="description" name="description" rows="3" placeholder="Detalles de aplicación y características técnicas..."><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                </div>

                <!-- Imagen del Producto -->
                <div class="col-md-6">
                    <label class="form-label text-xs fw-semibold text-muted text-uppercase">Imagen del Producto</label>
                    <?php if ($isEdit && !empty($product['image'])): ?>
                        <div class="d-flex align-items-center gap-2 mb-2 p-2 border rounded bg-light">
                            <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($product['image']) ?>" alt="Foto" height="45" class="rounded border">
                            <div class="text-xxs text-muted text-truncate"><?= htmlspecialchars($product['image']) ?></div>
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control form-control-sm" name="image" accept="image/*">
                    <input type="hidden" name="existing_image" value="<?= htmlspecialchars($product['image'] ?? 'default.png') ?>">
                    <small class="text-muted text-xxs d-block mt-1">Formatos: PNG, JPG, WEBP. Fondo blanco o transparente.</small>
                </div>

                <!-- Documento Ficha Técnica (PDF) -->
                <div class="col-md-6">
                    <label class="form-label text-xs fw-semibold text-muted text-uppercase">Documento de Ficha Técnica (PDF / Catálogo)</label>
                    <?php if ($isEdit && !empty($product['datasheet_pdf'])): ?>
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-2 p-2 border rounded bg-light">
                            <div class="d-flex align-items-center gap-2 text-truncate">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-5"></i>
                                <span class="text-xs fw-bold text-dark text-truncate"><?= htmlspecialchars($product['datasheet_pdf']) ?></span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <a href="<?= ASSETS_URL ?>/docs/datasheets/<?= htmlspecialchars($product['datasheet_pdf']) ?>" target="_blank" class="btn btn-xs btn-outline-primary">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input" type="checkbox" name="remove_datasheet" value="1" id="remove_datasheet">
                                    <label class="form-check-label text-xxs text-danger fw-semibold" for="remove_datasheet">Quitar</label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control form-control-sm" name="datasheet_pdf" accept=".pdf,.doc,.docx,application/pdf">
                    <input type="hidden" name="existing_datasheet_pdf" value="<?= htmlspecialchars($product['datasheet_pdf'] ?? '') ?>">
                    <small class="text-muted text-xxs d-block mt-1">Formatos: PDF, DOC, DOCX (Máx. 25MB). Estará disponible para descarga en la web.</small>
                </div>

                <!-- Precio de Venta (CLP) -->
                <div class="col-md-3">
                    <label for="price" class="form-label text-xs fw-semibold text-muted text-uppercase">Precio Unitario ($ CLP) *</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light text-muted">$</span>
                        <input type="number" class="form-control form-control-sm font-monospace fw-bold text-primary" id="price" name="price" value="<?= (float)($product['price'] ?? 150000) ?>" min="0" step="1000" placeholder="150000" required>
                    </div>
                </div>

                <!-- Stock Actual -->
                <div class="col-md-2">
                    <label for="stock" class="form-label text-xs fw-semibold text-muted text-uppercase">Stock Actual *</label>
                    <input type="number" class="form-control form-control-sm font-monospace text-center fw-bold" id="stock" name="stock" value="<?= (int)($product['stock'] ?? 10) ?>" min="0" required>
                </div>

                <!-- Stock Mínimo (Alerta) -->
                <div class="col-md-2">
                    <label for="min_stock" class="form-label text-xs fw-semibold text-muted text-uppercase">Stock Mínimo</label>
                    <input type="number" class="form-control form-control-sm font-monospace text-center" id="min_stock" name="min_stock" value="<?= (int)($product['min_stock'] ?? 2) ?>" min="0">
                </div>

                <!-- Ubicación en Bodega -->
                <div class="col-md-3">
                    <label for="warehouse_location" class="form-label text-xs fw-semibold text-muted text-uppercase">Ubicación en Bodega</label>
                    <input type="text" class="form-control form-control-sm" id="warehouse_location" name="warehouse_location" value="<?= htmlspecialchars($product['warehouse_location'] ?? 'Bodega Central - Santiago') ?>" placeholder="Bodega Central / Rack A-1">
                </div>

                <!-- SKU / Código de Almacén -->
                <div class="col-md-2">
                    <label for="sku" class="form-label text-xs fw-semibold text-muted text-uppercase">Código SKU</label>
                    <input type="text" class="form-control form-control-sm font-monospace" id="sku" name="sku" value="<?= htmlspecialchars($product['sku'] ?? '') ?>" placeholder="SKU-1001">
                </div>

                <!-- Switches de Estado -->
                <div class="col-md-4 d-flex align-items-center gap-3 pt-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= (!isset($product['is_active']) || $product['is_active']) ? 'checked' : '' ?>>
                        <label class="form-check-label text-xs fw-semibold text-dark" for="is_active">Activo en Web</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" <?= (!empty($product['is_featured'])) ? 'checked' : '' ?>>
                        <label class="form-check-label text-xs fw-semibold text-dark" for="is_featured">Destacado</label>
                    </div>
                </div>

                <!-- Especificaciones Técnicas Dinámicas -->
                <div class="col-12 border-top pt-3 mt-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label text-xs fw-bold text-dark text-uppercase mb-0">
                            <i class="bi bi-list-check text-primary me-1"></i> Ficha Técnica / Especificaciones
                        </label>
                        <button type="button" class="btn btn-xs btn-outline-primary" id="addSpecBtn">
                            <i class="bi bi-plus-lg"></i> <span>Agregar Parámetro</span>
                        </button>
                    </div>

                    <div id="specsContainer" class="d-flex flex-column gap-2">
                        <?php if (!empty($specs)): ?>
                            <?php foreach ($specs as $key => $val): ?>
                                <div class="row g-2 align-items-center spec-row">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control form-control-sm" name="spec_key[]" value="<?= htmlspecialchars($key) ?>" placeholder="Parámetro (ej: Rango de Torque)">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control form-control-sm" name="spec_val[]" value="<?= htmlspecialchars($val) ?>" placeholder="Valor (ej: 200 – 37.000 Lb-ple)">
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <button type="button" class="btn btn-xs btn-outline-danger remove-spec-btn"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="row g-2 align-items-center spec-row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm" name="spec_key[]" placeholder="Parámetro (ej: Presión de Trabajo)">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" name="spec_val[]" placeholder="Valor (ej: 700 bar)">
                                </div>
                                <div class="col-md-1 text-end">
                                    <button type="button" class="btn btn-xs btn-outline-danger remove-spec-btn"><i class="bi bi-x-lg"></i></button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?= ADMIN_URL ?>/?c=product" class="btn btn-sm btn-outline-secondary px-3">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold d-inline-flex align-items-center gap-1.5">
                    <i class="bi bi-check-circle-fill"></i> <span>Guardar Producto</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('addSpecBtn')?.addEventListener('click', function() {
    const container = document.getElementById('specsContainer');
    const row = document.createElement('div');
    row.className = 'row g-2 align-items-center spec-row';
    row.innerHTML = `
        <div class="col-md-5">
            <input type="text" class="form-control form-control-sm" name="spec_key[]" placeholder="Parámetro">
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control form-control-sm" name="spec_val[]" placeholder="Valor">
        </div>
        <div class="col-md-1 text-end">
            <button type="button" class="btn btn-xs btn-outline-danger remove-spec-btn"><i class="bi bi-x-lg"></i></button>
        </div>
    `;
    container.appendChild(row);
});

document.getElementById('specsContainer')?.addEventListener('click', function(e) {
    if (e.target.closest('.remove-spec-btn')) {
        e.target.closest('.spec-row').remove();
    }
});
</script>
