<?php
$pageTitle = 'Gestión de Categorías';
?>
<div class="card shadow-sm border-0 rounded-3 bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-tags text-primary me-2"></i>Líneas de Productos / Categorías</h6>
            <span class="badge bg-secondary-subtle text-secondary"><?= count($categories) ?> categorías</span>
        </div>

        <?php if (Auth::can('categories', 'create')): ?>
            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1.5 fw-semibold" data-bs-toggle="modal" data-bs-target="#newCategoryModal">
                <i class="bi bi-plus-lg"></i> <span>Nueva Categoría</span>
            </button>
        <?php endif; ?>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0 text-xs">
                <thead class="table-light text-uppercase text-xxs text-muted">
                    <tr>
                        <th class="ps-3" style="width: 50px;">Icono</th>
                        <th>Nombre de la Categoría</th>
                        <th>Slug (Identificador)</th>
                        <th>Descripción</th>
                        <th class="text-center">Productos</th>
                        <th class="text-center">Orden</th>
                        <th class="text-center">Estado</th>
                        <th class="text-end pe-3" style="width: 100px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $c): ?>
                        <tr>
                            <td class="ps-3 py-2 text-center">
                                <div class="avatar-circle-sm bg-primary-subtle text-primary mx-auto">
                                    <i class="bi <?= htmlspecialchars($c['icon'] ?: 'bi-tag') ?>"></i>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark"><?= htmlspecialchars($c['name']) ?></span>
                            </td>
                            <td>
                                <code><?= htmlspecialchars($c['slug']) ?></code>
                            </td>
                            <td>
                                <span class="text-muted text-truncate d-inline-block max-w-300" title="<?= htmlspecialchars($c['description'] ?? '') ?>">
                                    <?= htmlspecialchars($c['description'] ?: 'Sin descripción') ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info-subtle text-info border border-info-subtle"><?= (int)($c['product_count'] ?? 0) ?> items</span>
                            </td>
                            <td class="text-center fw-semibold text-muted">
                                #<?= $c['sort_order'] ?>
                            </td>
                            <td class="text-center">
                                <?php if ($c['is_active']): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Activa</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Inactiva</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= BASE_URL ?>/category.php?slug=<?= htmlspecialchars($c['slug']) ?>" target="_blank" class="btn btn-xs btn-outline-info" title="Ver Página Pública de Categoría">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                    <?php if (Auth::can('categories', 'edit')): ?>
                                        <button type="button" class="btn btn-xs btn-outline-primary edit-cat-btn" 
                                                data-id="<?= $c['id'] ?>"
                                                data-name="<?= htmlspecialchars($c['name']) ?>"
                                                data-slug="<?= htmlspecialchars($c['slug']) ?>"
                                                data-description="<?= htmlspecialchars($c['description'] ?? '') ?>"
                                                data-icon="<?= htmlspecialchars($c['icon'] ?? 'bi-tag') ?>"
                                                data-sort="<?= $c['sort_order'] ?>"
                                                data-active="<?= $c['is_active'] ?>"
                                                data-bs-toggle="modal" data-bs-target="#editCategoryModal" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if (Auth::can('categories', 'delete')): ?>
                                        <a href="<?= ADMIN_URL ?>/?c=category&a=delete&id=<?= $c['id'] ?>" class="btn btn-xs btn-outline-danger btn-delete" data-name="<?= htmlspecialchars($c['name']) ?>" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No se encontraron categorías registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nueva Categoría -->
<div class="modal fade" id="newCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= ADMIN_URL ?>/?c=category&a=create" method="POST">
                <div class="modal-header bg-light py-2.5">
                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-plus-circle text-primary me-2"></i>Nueva Categoría</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Nombre *</label>
                        <input type="text" class="form-control form-control-sm" name="name" required placeholder="Ej: Llaves de Torque">
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Slug (Identificador URL)</label>
                        <input type="text" class="form-control form-control-sm" name="slug" placeholder="Ej: llaves (dejar vacío para autogenerar)">
                    </div>
                    <div class="row g-2 mb-2.5">
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Icono Bootstrap</label>
                            <input type="text" class="form-control form-control-sm" name="icon" value="bi-tag" placeholder="Ej: bi-wrench">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Orden</label>
                            <input type="number" class="form-control form-control-sm" name="sort_order" value="1" min="0">
                        </div>
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Descripción</label>
                        <textarea class="form-control form-control-sm" name="description" rows="2" placeholder="Resumen de la categoría..."></textarea>
                    </div>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="catActiveNew" name="is_active" value="1" checked>
                        <label class="form-check-label text-xs fw-semibold text-dark" for="catActiveNew">Categoría Activa</label>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-primary">Guardar Categoría</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Categoría -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= ADMIN_URL ?>/?c=category&a=edit" method="POST">
                <input type="hidden" name="id" id="editCatId">
                <div class="modal-header bg-light py-2.5">
                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Categoría</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Nombre *</label>
                        <input type="text" class="form-control form-control-sm" name="name" id="editCatName" required>
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Slug (Identificador URL) *</label>
                        <input type="text" class="form-control form-control-sm" name="slug" id="editCatSlug" required>
                    </div>
                    <div class="row g-2 mb-2.5">
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Icono Bootstrap</label>
                            <input type="text" class="form-control form-control-sm" name="icon" id="editCatIcon">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Orden</label>
                            <input type="number" class="form-control form-control-sm" name="sort_order" id="editCatSort" min="0">
                        </div>
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Descripción</label>
                        <textarea class="form-control form-control-sm" name="description" id="editCatDesc" rows="2"></textarea>
                    </div>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="editCatActive" name="is_active" value="1">
                        <label class="form-check-label text-xs fw-semibold text-dark" for="editCatActive">Categoría Activa</label>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-primary">Actualizar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.edit-cat-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('editCatId').value = this.dataset.id;
        document.getElementById('editCatName').value = this.dataset.name;
        document.getElementById('editCatSlug').value = this.dataset.slug;
        document.getElementById('editCatDesc').value = this.dataset.description;
        document.getElementById('editCatIcon').value = this.dataset.icon;
        document.getElementById('editCatSort').value = this.dataset.sort;
        document.getElementById('editCatActive').checked = this.dataset.active == '1';
    });
});
</script>
