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
        <a href="<?= ADMIN_URL ?>/?c=product" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 text-xs">
            <i class="bi bi-arrow-left"></i> <span>Volver a Productos</span>
        </a>
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

                <!-- Imagen & Configuración -->
                <div class="col-md-4">
                    <label class="form-label text-xs fw-semibold text-muted text-uppercase">Imagen del Producto</label>
                    <?php if ($isEdit && !empty($product['image'])): ?>
                        <div class="d-flex align-items-center gap-2 mb-2 p-2 border rounded bg-light">
                            <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($product['image']) ?>" alt="Foto" height="45" class="rounded border">
                            <div class="text-xxs text-muted text-truncate"><?= htmlspecialchars($product['image']) ?></div>
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control form-control-sm" name="image" accept="image/*">
                    <input type="hidden" name="existing_image" value="<?= htmlspecialchars($product['image'] ?? 'default.png') ?>">
                    <small class="text-muted text-xxs d-block mt-1">Formatos: PNG, JPG, WEBP. Tamaño recomendado 600x400 px.</small>
                </div>

                <!-- Orden y Estados -->
                <div class="col-md-4">
                    <label for="sort_order" class="form-label text-xs fw-semibold text-muted text-uppercase">Orden en Catálogo</label>
                    <input type="number" class="form-control form-control-sm" id="sort_order" name="sort_order" value="<?= (int)($product['sort_order'] ?? 1) ?>" min="0">
                </div>

                <div class="col-md-4 d-flex align-items-center gap-3 pt-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= (!isset($product['is_active']) || $product['is_active']) ? 'checked' : '' ?>>
                        <label class="form-check-label text-xs fw-semibold text-dark" for="is_active">Producto Activo en Web</label>
                    </div>
                </div>

                <div class="col-md-4 d-flex align-items-center gap-3 pt-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" <?= (!empty($product['is_featured'])) ? 'checked' : '' ?>>
                        <label class="form-check-label text-xs fw-semibold text-dark" for="is_featured">Destacado en Portada</label>
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
