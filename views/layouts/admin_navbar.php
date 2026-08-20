<?php
/**
 * Barra Superior de Navegación (Navbar)
 */
?>
<!-- TOP NAVBAR -->
<nav class="admin-navbar navbar navbar-expand navbar-dark">
    <div class="container-fluid p-0 d-flex align-items-center justify-content-between">
        <!-- Left: Toggle & Breadcrumb -->
        <div class="d-flex align-items-center gap-3">
            <!-- Sidebar Toggle Button (Mobile) -->
            <button class="btn btn-sm btn-outline-light d-lg-none" id="sidebarToggleBtn" type="button" title="Alternar Menú">
                <i class="bi bi-list fs-5"></i>
            </button>

            <!-- Current Breadcrumb or Section Title -->
            <div class="navbar-title d-flex align-items-center gap-2">
                <span class="text-white-50 text-xs">Sistema</span>
                <i class="bi bi-chevron-right text-white-50 text-xxs"></i>
                <span class="text-white fw-semibold small"><?= htmlspecialchars($pageTitle ?? 'Panel de Control') ?></span>
            </div>
        </div>

        <!-- Right: Actions & User Dropdown -->
        <div class="d-flex align-items-center gap-2">
            <!-- View Public Catalog Link -->
            <a href="<?= BASE_URL ?>/index.php" target="_blank" class="btn btn-sm btn-outline-info d-flex align-items-center gap-1.5 py-1 px-2.5 text-xs fw-semibold" title="Abrir catálogo web público">
                <i class="bi bi-globe"></i>
                <span class="d-none d-md-inline">Ver Catálogo Web</span>
            </a>

            <!-- Notifications Badge -->
            <a href="<?= ADMIN_URL ?>/?c=quote" class="btn btn-sm btn-outline-warning position-relative py-1 px-2 text-xs" title="Cotizaciones">
                <i class="bi bi-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">Alertas</span>
                </span>
            </a>

            <div class="vr bg-secondary opacity-50 mx-1" style="height: 20px;"></div>

            <!-- User Dropdown -->
            <div class="dropdown">
                <button class="btn btn-sm btn-dark dropdown-toggle d-flex align-items-center gap-2 py-1 px-2 border-0 bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar" style="width: 28px; height: 28px; font-size: 0.75rem;">
                        <?= strtoupper(substr($currentUser['name'] ?? 'U', 0, 1)) ?>
                    </div>
                    <span class="text-white small fw-medium d-none d-md-inline text-truncate max-w-150">
                        <?= htmlspecialchars($currentUser['name'] ?? 'Usuario') ?>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-dark-subtle text-sm">
                    <li class="dropdown-header py-2">
                        <div class="fw-bold text-dark"><?= htmlspecialchars($currentUser['name'] ?? 'Usuario') ?></div>
                        <div class="text-muted text-xs"><?= htmlspecialchars($currentUser['email'] ?? '') ?></div>
                        <span class="badge bg-primary text-xxs mt-1"><?= htmlspecialchars($currentUser['role_name'] ?? 'Sin Rol') ?></span>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item py-1.5 d-flex align-items-center gap-2" href="<?= ADMIN_URL ?>/?c=auth&a=profile">
                            <i class="bi bi-person-gear text-primary"></i> Mi Perfil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-1.5 d-flex align-items-center gap-2" href="<?= BASE_URL ?>/index.php" target="_blank">
                            <i class="bi bi-box-arrow-up-right text-info"></i> Ver Catálogo Web
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item py-1.5 text-danger d-flex align-items-center gap-2" href="<?= ADMIN_URL ?>/?c=auth&a=logout">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- MAIN CONTENT CONTAINER -->
<main class="admin-content">
    <!-- Flash Messages Container -->
    <?php if (!empty($flashSuccess)): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 py-2 px-3 mb-3 shadow-xs border-success" role="alert">
            <i class="bi bi-check-circle-fill text-success fs-5"></i>
            <div class="small flex-grow-1"><?= htmlspecialchars($flashSuccess) ?></div>
            <button type="button" class="btn-close py-2.5 px-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($flashError)): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 py-2 px-3 mb-3 shadow-xs border-danger" role="alert">
            <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
            <div class="small flex-grow-1"><?= htmlspecialchars($flashError) ?></div>
            <button type="button" class="btn-close py-2.5 px-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($flashWarning)): ?>
        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center gap-2 py-2 px-3 mb-3 shadow-xs border-warning" role="alert">
            <i class="bi bi-exclamation-circle-fill text-warning fs-5"></i>
            <div class="small flex-grow-1"><?= htmlspecialchars($flashWarning) ?></div>
            <button type="button" class="btn-close py-2.5 px-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
