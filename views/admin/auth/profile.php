<?php
$pageTitle = 'Mi Perfil';
?>
<div class="row g-3">
    <!-- Profile Card -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 rounded-3 bg-white">
            <div class="card-body text-center p-4">
                <div class="avatar-circle-lg bg-primary text-white fw-bold mx-auto mb-3 fs-3">
                    <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                </div>
                <h5 class="fw-bold mb-1"><?= htmlspecialchars($user['name'] ?? '') ?></h5>
                <p class="text-muted small mb-2"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                <span class="badge bg-primary text-xs px-3 py-1.5"><?= htmlspecialchars($user['role_name'] ?? 'Sin Rol') ?></span>

                <hr class="my-3">

                <div class="text-start text-xs text-muted">
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span>Teléfono:</span>
                        <strong class="text-dark"><?= htmlspecialchars($user['phone'] ?: 'No registrado') ?></strong>
                    </div>
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span>Estado:</span>
                        <span class="badge bg-success">Activo</span>
                    </div>
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span>Último acceso:</span>
                        <strong class="text-dark"><?= htmlspecialchars($user['last_login'] ?: 'Primera sesión') ?></strong>
                    </div>
                    <div class="d-flex justify-content-between py-1">
                        <span>Miembro desde:</span>
                        <strong class="text-dark"><?= date('d/m/Y', strtotime($user['created_at'] ?? 'now')) ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile & Password Form -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3 bg-white">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-person-gear text-primary me-2"></i>Actualizar Datos y Contraseña</h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= ADMIN_URL ?>/?c=auth&a=profile" method="POST">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label text-xs fw-semibold text-muted text-uppercase">Nombre Completo *</label>
                            <input type="text" class="form-control form-control-sm" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label text-xs fw-semibold text-muted text-uppercase">Teléfono de Contacto</label>
                            <input type="text" class="form-control form-control-sm" id="phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Correo Electrónico</label>
                            <input type="email" class="form-control form-control-sm bg-light" value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled readonly>
                            <small class="text-muted text-xs">El correo no puede ser modificado.</small>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark border-top pt-3 mb-3"><i class="bi bi-shield-lock text-warning me-2"></i>Cambiar Contraseña (Opcional)</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="current_password" class="form-label text-xs fw-semibold text-muted text-uppercase">Contraseña Actual</label>
                            <input type="password" class="form-control form-control-sm" id="current_password" name="current_password" placeholder="••••••••">
                        </div>
                        <div class="col-md-4">
                            <label for="new_password" class="form-label text-xs fw-semibold text-muted text-uppercase">Nueva Contraseña</label>
                            <input type="password" class="form-control form-control-sm" id="new_password" name="new_password" placeholder="Mínimo 6 caracteres">
                        </div>
                        <div class="col-md-4">
                            <label for="confirm_password" class="form-label text-xs fw-semibold text-muted text-uppercase">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control form-control-sm" id="confirm_password" name="confirm_password" placeholder="Repita contraseña">
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold d-flex align-items-center gap-1.5">
                            <i class="bi bi-save"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
