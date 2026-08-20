<?php
$pageTitle = 'Permisos del Rol: ' . $role['name'];
?>
<div class="card shadow-sm border-0 rounded-3 bg-white">
    <!-- Header -->
    <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
        <div>
            <div class="d-flex align-items-center gap-2">
                <h6 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-shield-lock text-primary me-1"></i> Matriz de Permisos para: <span class="badge bg-primary fs-6"><?= htmlspecialchars($role['name']) ?></span>
                </h6>
                <?php if ($role['is_system']): ?>
                    <span class="badge bg-dark-subtle text-dark border">Rol del Sistema</span>
                <?php endif; ?>
            </div>
            <small class="text-muted text-xs">Configure qué menús puede ver este rol y qué permisos de acción (Crear, Editar, Eliminar) tiene asignados.</small>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="<?= ADMIN_URL ?>/?c=role" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 text-xs">
                <i class="bi bi-arrow-left"></i> Volver a Roles
            </a>
        </div>
    </div>

    <!-- Permissions Form Matrix -->
    <div class="card-body p-4">
        <form action="<?= ADMIN_URL ?>/?c=role&a=permissions&id=<?= $role['id'] ?>" method="POST">
            <!-- Global Select All / Deselect All Toolbar -->
            <div class="d-flex justify-content-between align-items-center p-2 mb-3 bg-light rounded border text-xs">
                <span class="fw-semibold text-muted">Acciones Rápidas de Configuración:</span>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-xs btn-outline-primary" id="selectAllBtn"><i class="bi bi-check-all"></i> Marcar Todo</button>
                    <button type="button" class="btn btn-xs btn-outline-secondary" id="deselectAllBtn"><i class="bi bi-x"></i> Desmarcar Todo</button>
                    <button type="button" class="btn btn-xs btn-outline-info" id="viewOnlyBtn"><i class="bi bi-eye"></i> Solo Lectura (Ver)</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle text-xs mb-0">
                    <thead class="table-dark text-uppercase text-xxs">
                        <tr>
                            <th class="ps-3" style="width: 250px;">Módulo / Menú del Sistema</th>
                            <th class="text-center" style="width: 120px;">
                                <i class="bi bi-eye me-1"></i> Ver Menú
                            </th>
                            <th class="text-center" style="width: 120px;">
                                <i class="bi bi-plus-circle me-1"></i> Crear
                            </th>
                            <th class="text-center" style="width: 120px;">
                                <i class="bi bi-pencil me-1"></i> Editar
                            </th>
                            <th class="text-center" style="width: 120px;">
                                <i class="bi bi-trash me-1"></i> Eliminar
                            </th>
                            <th class="text-center" style="width: 100px;">Fila</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menus as $m): 
                            $p = $permMap[$m['id']] ?? null;
                            $canView = !empty($p['can_view']);
                            $canCreate = !empty($p['can_create']);
                            $canEdit = !empty($p['can_edit']);
                            $canDelete = !empty($p['can_delete']);
                        ?>
                        <tr class="perm-row">
                            <td class="ps-3 py-2.5">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle-sm bg-light text-primary">
                                        <i class="bi <?= htmlspecialchars($m['icon'] ?: 'bi-circle') ?>"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($m['title']) ?></div>
                                        <code class="text-xxs text-muted">Módulo: <?= htmlspecialchars($m['module_code']) ?></code>
                                    </div>
                                </div>
                            </td>

                            <!-- View Permission Checkbox -->
                            <td class="text-center bg-light">
                                <div class="form-check d-flex justify-content-center p-0 mb-0">
                                    <input class="form-check-input perm-cb perm-view" type="checkbox" 
                                           name="perm[<?= $m['id'] ?>][view]" value="1" 
                                           <?= $canView ? 'checked' : '' ?>
                                           id="view_<?= $m['id'] ?>">
                                </div>
                            </td>

                            <!-- Create Permission Checkbox -->
                            <td class="text-center">
                                <div class="form-check d-flex justify-content-center p-0 mb-0">
                                    <input class="form-check-input perm-cb perm-create" type="checkbox" 
                                           name="perm[<?= $m['id'] ?>][create]" value="1" 
                                           <?= $canCreate ? 'checked' : '' ?>
                                           id="create_<?= $m['id'] ?>">
                                </div>
                            </td>

                            <!-- Edit Permission Checkbox -->
                            <td class="text-center">
                                <div class="form-check d-flex justify-content-center p-0 mb-0">
                                    <input class="form-check-input perm-cb perm-edit" type="checkbox" 
                                           name="perm[<?= $m['id'] ?>][edit]" value="1" 
                                           <?= $canEdit ? 'checked' : '' ?>
                                           id="edit_<?= $m['id'] ?>">
                                </div>
                            </td>

                            <!-- Delete Permission Checkbox -->
                            <td class="text-center">
                                <div class="form-check d-flex justify-content-center p-0 mb-0">
                                    <input class="form-check-input perm-cb perm-delete" type="checkbox" 
                                           name="perm[<?= $m['id'] ?>][delete]" value="1" 
                                           <?= $canDelete ? 'checked' : '' ?>
                                           id="delete_<?= $m['id'] ?>">
                                </div>
                            </td>

                            <!-- Row Select All -->
                            <td class="text-center">
                                <button type="button" class="btn btn-xxs btn-outline-secondary row-toggle-btn" title="Alternar fila">
                                    <i class="bi bi-toggle-on"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Submit Button -->
            <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                <span class="text-muted text-xs"><i class="bi bi-info-circle me-1"></i>Los cambios en permisos se aplican inmediatamente al menú de los usuarios del rol.</span>
                <div class="d-flex gap-2">
                    <a href="<?= ADMIN_URL ?>/?c=role" class="btn btn-sm btn-outline-secondary px-3">Cancelar</a>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold d-flex align-items-center gap-1.5 shadow-sm">
                        <i class="bi bi-save"></i> Guardar Matriz de Permisos
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Select All
document.getElementById('selectAllBtn')?.addEventListener('click', () => {
    document.querySelectorAll('.perm-cb').forEach(cb => cb.checked = true);
});

// Deselect All
document.getElementById('deselectAllBtn')?.addEventListener('click', () => {
    document.querySelectorAll('.perm-cb').forEach(cb => cb.checked = false);
});

// View Only
document.getElementById('viewOnlyBtn')?.addEventListener('click', () => {
    document.querySelectorAll('.perm-cb').forEach(cb => cb.checked = false);
    document.querySelectorAll('.perm-view').forEach(cb => cb.checked = true);
});

// Toggle Row
document.querySelectorAll('.row-toggle-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const row = this.closest('.perm-row');
        const cbs = row.querySelectorAll('.perm-cb');
        const anyUnchecked = Array.from(cbs).some(cb => !cb.checked);
        cbs.forEach(cb => cb.checked = anyUnchecked);
    });
});

// Auto-check View when Create/Edit/Delete is checked
document.querySelectorAll('.perm-create, .perm-edit, .perm-delete').forEach(cb => {
    cb.addEventListener('change', function() {
        if (this.checked) {
            const row = this.closest('.perm-row');
            row.querySelector('.perm-view').checked = true;
        }
    });
});
</script>
