<?php
$pageTitle = 'Gestión de Usuarios';
?>
<div class="card shadow-sm border-0 rounded-3 bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-people text-primary me-2"></i>Usuarios del Sistema</h6>
            <span class="badge bg-secondary-subtle text-secondary"><?= count($users) ?> usuarios</span>
        </div>

        <?php if (Auth::can('users', 'create')): ?>
            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1.5 fw-semibold" data-bs-toggle="modal" data-bs-target="#newUserModal">
                <i class="bi bi-person-plus"></i> <span>Nuevo Usuario</span>
            </button>
        <?php endif; ?>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0 text-xs">
                <thead class="table-light text-uppercase text-xxs text-muted">
                    <tr>
                        <th class="ps-3" style="width: 50px;">Avatar</th>
                        <th>Nombre y Apellido</th>
                        <th>Correo Electrónico</th>
                        <th>Rol Asignado</th>
                        <th>Teléfono</th>
                        <th>Último Acceso</th>
                        <th class="text-center">Estado</th>
                        <th class="text-end pe-3" style="width: 100px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td class="ps-3 py-2 text-center">
                                <div class="avatar-circle-sm bg-primary text-white fw-bold mx-auto">
                                    <?= strtoupper(substr($u['name'] ?? 'U', 0, 1)) ?>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($u['name']) ?></div>
                                <?php if ($u['id'] === Auth::id()): ?>
                                    <span class="badge bg-info-subtle text-info text-xxs">Tú (Sesión actual)</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="mailto:<?= htmlspecialchars($u['email']) ?>" class="text-muted text-decoration-none">
                                    <?= htmlspecialchars($u['email']) ?>
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                    <?= htmlspecialchars($u['role_name'] ?? 'Sin Rol') ?>
                                </span>
                            </td>
                            <td class="text-muted">
                                <?= htmlspecialchars($u['phone'] ?: '—') ?>
                            </td>
                            <td class="text-muted text-xxs">
                                <?= htmlspecialchars($u['last_login'] ? date('d/m/Y H:i', strtotime($u['last_login'])) : 'Nunca') ?>
                            </td>
                            <td class="text-center">
                                <?php if ($u['is_active']): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <?php if (Auth::can('users', 'edit')): ?>
                                        <a href="<?= ADMIN_URL ?>/?c=user&a=toggle&id=<?= $u['id'] ?>" class="btn btn-xs btn-outline-secondary" title="Cambiar Estado">
                                            <i class="bi <?= $u['is_active'] ? 'bi-toggle-on text-success' : 'bi-toggle-off text-muted' ?>"></i>
                                        </a>
                                        <button type="button" class="btn btn-xs btn-outline-primary edit-user-btn"
                                                data-id="<?= $u['id'] ?>"
                                                data-name="<?= htmlspecialchars($u['name']) ?>"
                                                data-email="<?= htmlspecialchars($u['email']) ?>"
                                                data-role="<?= $u['role_id'] ?>"
                                                data-phone="<?= htmlspecialchars($u['phone'] ?? '') ?>"
                                                data-active="<?= $u['is_active'] ?>"
                                                data-bs-toggle="modal" data-bs-target="#editUserModal" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if (Auth::can('users', 'delete') && $u['id'] !== Auth::id()): ?>
                                        <a href="<?= ADMIN_URL ?>/?c=user&a=delete&id=<?= $u['id'] ?>" class="btn btn-xs btn-outline-danger btn-delete" data-name="<?= htmlspecialchars($u['name']) ?>" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No se encontraron usuarios registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nuevo Usuario -->
<div class="modal fade" id="newUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= ADMIN_URL ?>/?c=user&a=create" method="POST">
                <div class="modal-header bg-light py-2.5">
                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-person-plus text-primary me-2"></i>Nuevo Usuario</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Nombre Completo *</label>
                        <input type="text" class="form-control form-control-sm" name="name" required placeholder="Ej: Juan Pérez">
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Correo Electrónico *</label>
                        <input type="email" class="form-control form-control-sm" name="email" required placeholder="juan.perez@victorq.com">
                    </div>
                    <div class="row g-2 mb-2.5">
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Rol de Usuario *</label>
                            <select class="form-select form-select-sm" name="role_id" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($roles as $r): ?>
                                    <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Teléfono</label>
                            <input type="text" class="form-control form-control-sm" name="phone" placeholder="+56 9 ...">
                        </div>
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Contraseña Inicial *</label>
                        <input type="password" class="form-control form-control-sm" name="password" required placeholder="Mínimo 6 caracteres">
                    </div>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="userActiveNew" name="is_active" value="1" checked>
                        <label class="form-check-label text-xs fw-semibold text-dark" for="userActiveNew">Usuario Activo</label>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-primary">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="<?= ADMIN_URL ?>/?c=user&a=edit" method="POST">
                <input type="hidden" name="id" id="editUserId">
                <div class="modal-header bg-light py-2.5">
                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-person-gear text-primary me-2"></i>Editar Usuario</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Nombre Completo *</label>
                        <input type="text" class="form-control form-control-sm" name="name" id="editUserName" required>
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Correo Electrónico *</label>
                        <input type="email" class="form-control form-control-sm" name="email" id="editUserEmail" required>
                    </div>
                    <div class="row g-2 mb-2.5">
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Rol de Usuario *</label>
                            <select class="form-select form-select-sm" name="role_id" id="editUserRole" required>
                                <?php foreach ($roles as $r): ?>
                                    <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Teléfono</label>
                            <input type="text" class="form-control form-control-sm" name="phone" id="editUserPhone">
                        </div>
                    </div>
                    <div class="mb-2.5">
                        <label class="form-label text-xs fw-semibold text-muted text-uppercase">Cambiar Contraseña (opcional)</label>
                        <input type="password" class="form-control form-control-sm" name="password" placeholder="Dejar vacío para conservar">
                    </div>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="editUserActive" name="is_active" value="1">
                        <label class="form-check-label text-xs fw-semibold text-dark" for="editUserActive">Usuario Activo</label>
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
document.querySelectorAll('.edit-user-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('editUserId').value = this.dataset.id;
        document.getElementById('editUserName').value = this.dataset.name;
        document.getElementById('editUserEmail').value = this.dataset.email;
        document.getElementById('editUserRole').value = this.dataset.role;
        document.getElementById('editUserPhone').value = this.dataset.phone;
        document.getElementById('editUserActive').checked = this.dataset.active == '1';
    });
});
</script>
