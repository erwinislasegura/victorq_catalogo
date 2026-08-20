<?php
$pageTitle = 'Acceso Restringido (403)';
?>
<div class="card shadow-sm border-0 rounded-3 bg-white text-center p-5 my-4">
    <div class="avatar-circle-lg bg-danger-subtle text-danger mx-auto mb-3" style="width: 80px; height: 80px; font-size: 36px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
        <i class="bi bi-shield-x"></i>
    </div>
    <h3 class="fw-bold text-dark mb-2">403 — Acceso No Autorizado</h3>
    <p class="text-muted text-sm max-w-500 mx-auto mb-4">
        Su rol actual (<strong><?= htmlspecialchars(Auth::roleName() ?: 'Usuario') ?></strong>) no cuenta con los permisos necesarios para ver o modificar este módulo.
    </p>
    <div class="d-flex justify-content-center gap-2">
        <a href="<?= ADMIN_URL ?>/?c=dashboard" class="btn btn-primary btn-sm px-4 fw-semibold">
            <i class="bi bi-speedometer2 me-1"></i> Ir al Dashboard
        </a>
        <a href="<?= BASE_URL ?>/index.php" target="_blank" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-globe me-1"></i> Ver Catálogo Web
        </a>
    </div>
</div>
