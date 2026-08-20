<?php
$pageTitle = 'Roles y Permisos';
?>
<div class="card shadow-sm border-0 rounded-3 bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-shield-lock text-primary me-2"></i>Roles de Usuario y Control de Acceso (RBAC)</h6>
            <span class="badge bg-secondary-subtle text-secondary"><?= count($roles) ?> roles</span>
        </div>

        <?php if (Auth::can('roles', 'create')): ?>
            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1.5 fw-semibold" data-bs-toggle="modal" data-bs-target="#newRoleModal">
                <i class="bi bi-plus-lg"></i> <span>Nuevo Rol</span>
            </button>
        <?php endif; ?>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0 text-xs">
                <thead class="table-light text-uppercase text-xxs text-muted">
                    <tr>
                        <th class="ps-3" style="width: 50px;">#ID</th>
                        <th>Nombre del Rol</th>
                        <th>Identificador (Slug)</th>
                        <th>Descripción</th>
                        <th class="text-center">Usuarios Asignados</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-end pe-3" style="width: 160px;">Acciones y Permisos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($roles)): ?>
                        <?php foreach ($roles as $r): ?>
                        <tr>
                            <td class="ps-3 py-2.5 fw-bold text-muted">#<?= $r['id'] ?></td>
                            <td>
                                <span class="fw-bold text-dark fs-6"><?= htmlspecialchars($r['name']) ?></span>
                            </td>
                            <td>
                                <code><?= htmlspecialchars($r['slug']) ?></code>
                            </td>
                            <td>
                                <span class="text-muted"><?= htmlspecialchars($r['description'] ?: 'Sin descripción') ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info-subtle text-info border border-info-subtle"><?= (int)($r['user_count'] ?? 0) ?> usuarios</span>
                            </td>
                            <td class="text-center">
                                <?php if ($r['is_system']): ?>
                                    <span class="badge bg-dark-subtle text-dark border"><i class="bi bi-lock-fill me-1"></i>Sistema</span>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted border">Personalizado</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <!-- Permissions Matrix Button -->
                                    <a href="<?= ADMIN_URL ?>/?c=role&a=permissions&id=<?= $r['id'] ?>" class="btn btn-xs btn-primary d-flex align-items-center gap-1" title="Configurar Permisos de Menús y Acciones">
                                        <i class="bi bi-sliders"></i> Permisos
                                    </a>
                                    <?php if (Auth::can('roles', 'edit') && !$r['is_system']): ?>
                                        <button type="button" class="btn btn-xs btn-outline-secondary edit-role-btn"
                                                data-id="<?= $r['id'] ?>"
                                                data-name="<?= htmlspecialchars($r['name']) ?>"
                                                data-description="<?= htmlspecialchars($r['description'] ?? '') ?>"
                                                data-bs-toggle="modal" data-bs-target="#editRoleModal" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if (Auth::can('roles', 'delete') && !$r['is_system'] && $r['id'] !== 1): ?>
                                        <a href="<?= ADMIN_URL ?>/?c=role&a=delete&id=<?= $r['id'] ?>" class="btn btn-xs btn-outline-danger btn-delete" data-name="<?= htmlspecialchars($r['name']) ?>" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No se encontraron roles registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nuevo Rol -->
<div class="modal fade" id="newRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= ADMIN_URL ?>/?c=role&a=create" method="POST">
                <div class="modal-header bg-light py-2.5">
                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-plus-circle text-primary me-2"></i>Nuevo Rol</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Nombre del Rol *</label>
                        <input type="text" class="form-control form-control-sm" name="name" required placeholder="Ej: Auditor de Calidad">
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Identificador (Slug)</label>
                        <input type="text" class="form-control form-control-sm" name="slug" placeholder="Ej: auditor (dejar vacío para autogenerar)">
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Descripción del Rol</label>
                        <textarea class="form-control form-control-sm" name="description" rows="2" placeholder="Alcance de responsabilidades..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-primary">Crear Rol y Configurar Permisos</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Rol -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= ADMIN_URL ?>/?c=role&a=edit" method="POST">
                <input type="hidden" name="id" id="editRoleId">
                <div class="modal-header bg-light py-2.5">
                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Rol</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Nombre del Rol *</label>
                        <input type="text" class="form-control form-control-sm" name="name" id="editRoleName" required>
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Descripción del Rol</label>
                        <textarea class="form-control form-control-sm" name="description" id="editRoleDesc" rows="2"></textarea>
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
document.querySelectorAll('.edit-role-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('editRoleId').value = this.dataset.id;
        document.getElementById('editRoleName').value = this.dataset.name;
        document.getElementById('editRoleDesc').value = this.dataset.description;
    });
});
</script>
