<?php
$pageTitle = 'Gestión de Menús del Sistema';
?>
<div class="card shadow-sm border-0 rounded-3 bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-menu-button-wide text-primary me-2"></i>Estructura de Menús Dinámicos</h6>
            <span class="badge bg-secondary-subtle text-secondary"><?= count($menus) ?> elementos</span>
        </div>

        <?php if (Auth::can('menus', 'create')): ?>
            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1.5 fw-semibold" data-bs-toggle="modal" data-bs-target="#newMenuModal">
                <i class="bi bi-plus-lg"></i> <span>Nuevo Menú</span>
            </button>
        <?php endif; ?>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0 text-xs">
                <thead class="table-light text-uppercase text-xxs text-muted">
                    <tr>
                        <th class="ps-3" style="width: 50px;">Icono</th>
                        <th>Título del Menú</th>
                        <th>Código del Módulo</th>
                        <th>URL / Ruta</th>
                        <th>Badge / Etiqueta</th>
                        <th class="text-center">Orden</th>
                        <th class="text-center">Roles con Acceso</th>
                        <th class="text-center">Estado</th>
                        <th class="text-end pe-3" style="width: 100px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($menus)): ?>
                        <?php foreach ($menus as $m): ?>
                        <tr>
                            <td class="ps-3 py-2.5 text-center">
                                <div class="avatar-circle-sm bg-primary-subtle text-primary mx-auto">
                                    <i class="bi <?= htmlspecialchars($m['icon'] ?: 'bi-circle') ?>"></i>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark"><?= htmlspecialchars($m['title']) ?></span>
                            </td>
                            <td>
                                <code><?= htmlspecialchars($m['module_code']) ?></code>
                            </td>
                            <td>
                                <span class="text-muted font-monospace text-xxs"><?= htmlspecialchars($m['url']) ?></span>
                            </td>
                            <td>
                                <?php if (!empty($m['badge'])): ?>
                                    <span class="badge <?= htmlspecialchars($m['badge_class'] ?? 'bg-primary') ?> text-xxs">
                                        <?= htmlspecialchars($m['badge']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted text-xxs">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center fw-semibold text-muted">
                                #<?= $m['sort_order'] ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border"><?= (int)($m['roles_assigned'] ?? 0) ?> roles</span>
                            </td>
                            <td class="text-center">
                                <?php if ($m['is_active']): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <?php if (Auth::can('menus', 'edit')): ?>
                                        <button type="button" class="btn btn-xs btn-outline-primary edit-menu-btn"
                                                data-id="<?= $m['id'] ?>"
                                                data-title="<?= htmlspecialchars($m['title']) ?>"
                                                data-module="<?= htmlspecialchars($m['module_code']) ?>"
                                                data-url="<?= htmlspecialchars($m['url']) ?>"
                                                data-icon="<?= htmlspecialchars($m['icon']) ?>"
                                                data-badge="<?= htmlspecialchars($m['badge'] ?? '') ?>"
                                                data-badge-class="<?= htmlspecialchars($m['badge_class'] ?? 'bg-primary') ?>"
                                                data-sort="<?= $m['sort_order'] ?>"
                                                data-active="<?= $m['is_active'] ?>"
                                                data-bs-toggle="modal" data-bs-target="#editMenuModal" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if (Auth::can('menus', 'delete')): ?>
                                        <a href="<?= ADMIN_URL ?>/?c=menu&a=delete&id=<?= $m['id'] ?>" class="btn btn-xs btn-outline-danger btn-delete" data-name="<?= htmlspecialchars($m['title']) ?>" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">No se encontraron menús registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nuevo Menú -->
<div class="modal fade" id="newMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= ADMIN_URL ?>/?c=menu&a=create" method="POST">
                <div class="modal-header bg-light py-2.5">
                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-plus-circle text-primary me-2"></i>Nuevo Menú</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Título del Menú *</label>
                        <input type="text" class="form-control form-control-sm" name="title" required placeholder="Ej: Reportes">
                    </div>
                    <div class="row g-2 mb-2.5">
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Código de Módulo *</label>
                            <input type="text" class="form-control form-control-sm" name="module_code" required placeholder="Ej: reports">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">URL / Ruta *</label>
                            <input type="text" class="form-control form-control-sm" name="url" required placeholder="?c=report">
                        </div>
                    </div>
                    <div class="row g-2 mb-2.5">
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Icono Bootstrap</label>
                            <input type="text" class="form-control form-control-sm" name="icon" value="bi-circle" placeholder="bi-bar-chart">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Orden</label>
                            <input type="number" class="form-control form-control-sm" name="sort_order" value="1" min="0">
                        </div>
                    </div>
                    <div class="row g-2 mb-2.5">
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Badge / Etiqueta</label>
                            <input type="text" class="form-control form-control-sm" name="badge" placeholder="Ej: Nuevo">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Clase del Badge</label>
                            <select class="form-select form-select-sm" name="badge_class">
                                <option value="bg-primary">Azul (Primary)</option>
                                <option value="bg-success">Verde (Success)</option>
                                <option value="bg-warning text-dark">Amarillo (Warning)</option>
                                <option value="bg-danger">Rojo (Danger)</option>
                                <option value="bg-info">Celeste (Info)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="menuActiveNew" name="is_active" value="1" checked>
                        <label class="form-check-label text-xs fw-semibold text-dark" for="menuActiveNew">Menú Activo</label>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-primary">Guardar Menú</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Menú -->
<div class="modal fade" id="editMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= ADMIN_URL ?>/?c=menu&a=edit" method="POST">
                <input type="hidden" name="id" id="editMenuId">
                <div class="modal-header bg-light py-2.5">
                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Menú</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Título del Menú *</label>
                        <input type="text" class="form-control form-control-sm" name="title" id="editMenuTitle" required>
                    </div>
                    <div class="row g-2 mb-2.5">
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Código de Módulo *</label>
                            <input type="text" class="form-control form-control-sm" name="module_code" id="editMenuModule" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">URL / Ruta *</label>
                            <input type="text" class="form-control form-control-sm" name="url" id="editMenuUrl" required>
                        </div>
                    </div>
                    <div class="row g-2 mb-2.5">
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Icono Bootstrap</label>
                            <input type="text" class="form-control form-control-sm" name="icon" id="editMenuIcon">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Orden</label>
                            <input type="number" class="form-control form-control-sm" name="sort_order" id="editMenuSort" min="0">
                        </div>
                    </div>
                    <div class="row g-2 mb-2.5">
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Badge / Etiqueta</label>
                            <input type="text" class="form-control form-control-sm" name="badge" id="editMenuBadge">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Clase del Badge</label>
                            <select class="form-select form-select-sm" name="badge_class" id="editMenuBadgeClass">
                                <option value="bg-primary">Azul (Primary)</option>
                                <option value="bg-success">Verde (Success)</option>
                                <option value="bg-warning text-dark">Amarillo (Warning)</option>
                                <option value="bg-danger">Rojo (Danger)</option>
                                <option value="bg-info">Celeste (Info)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="editMenuActive" name="is_active" value="1">
                        <label class="form-check-label text-xs fw-semibold text-dark" for="editMenuActive">Menú Activo</label>
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
document.querySelectorAll('.edit-menu-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('editMenuId').value = this.dataset.id;
        document.getElementById('editMenuTitle').value = this.dataset.title;
        document.getElementById('editMenuModule').value = this.dataset.module;
        document.getElementById('editMenuUrl').value = this.dataset.url;
        document.getElementById('editMenuIcon').value = this.dataset.icon;
        document.getElementById('editMenuBadge').value = this.dataset.badge;
        document.getElementById('editMenuBadgeClass').value = this.dataset.badgeClass;
        document.getElementById('editMenuSort').value = this.dataset.sort;
        document.getElementById('editMenuActive').checked = this.dataset.active == '1';
    });
});
</script>
