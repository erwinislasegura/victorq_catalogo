<?php
/**
 * Barra Superior de Navegación (Navbar) Moderna y Funcional
 */
$moduleIcons = [
    'dashboard' => 'bi-speedometer2 text-primary',
    'product' => 'bi-box-seam text-success',
    'products' => 'bi-box-seam text-success',
    'quote' => 'bi-file-earmark-text text-warning',
    'quotes' => 'bi-file-earmark-text text-warning',
    'category' => 'bi-tags text-info',
    'categories' => 'bi-tags text-info',
    'inventory' => 'bi-boxes text-primary',
    'contact' => 'bi-envelope-paper text-danger',
    'contacts' => 'bi-envelope-paper text-danger',
    'payment_config' => 'bi-credit-card-2-front text-success',
    'user' => 'bi-people text-secondary',
    'role' => 'bi-shield-lock text-danger',
    'menu' => 'bi-list-check text-primary',
    'auth' => 'bi-person-circle text-primary'
];

$curMod = strtolower($_GET['c'] ?? 'dashboard');
$curIcon = $moduleIcons[$curMod] ?? 'bi-layers text-primary';
?>
<!-- TOP NAVBAR -->
<nav class="admin-navbar navbar navbar-expand">
    <div class="container-fluid p-0 d-flex align-items-center justify-content-between">
        <!-- Left: Toggle & Breadcrumb -->
        <div class="d-flex align-items-center gap-3">
            <!-- Sidebar Toggle Button (Mobile) -->
            <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggleBtn" type="button" title="Alternar Menú">
                <i class="bi bi-list fs-5"></i>
            </button>

            <!-- Current Breadcrumb or Section Title -->
            <div class="navbar-title d-flex align-items-center gap-2">
                <span class="badge bg-light text-secondary border d-none d-sm-inline-flex align-items-center gap-1 text-xxs">
                    <i class="bi <?= $curIcon ?>"></i>
                    <span>VICTORQ ADMIN</span>
                </span>
                <i class="bi bi-chevron-right text-muted text-xxs d-none d-sm-inline"></i>
                <span class="text-dark fw-bold small text-truncate" style="font-size: 0.9rem;">
                    <?= htmlspecialchars($pageTitle ?? 'Panel de Control') ?>
                </span>
            </div>
        </div>

        <!-- Right: Fast Actions & User Profile -->
        <div class="d-flex align-items-center gap-2">
            <!-- Quick Action: Nueva Cotización -->
            <?php if (Auth::can('quotes', 'create')): ?>
                <a href="<?= ADMIN_URL ?>/?c=quote&a=create" class="btn btn-sm btn-primary d-none d-md-inline-flex align-items-center gap-1.5 text-xs fw-bold shadow-xs py-1.5 px-3">
                    <i class="bi bi-file-earmark-plus-fill"></i>
                    <span>+ Cotización</span>
                </a>
            <?php endif; ?>

            <!-- Quick Action: Nuevo Producto -->
            <?php if (Auth::can('products', 'create')): ?>
                <a href="<?= ADMIN_URL ?>/?c=product&a=create" class="btn btn-sm btn-outline-primary d-none d-lg-inline-flex align-items-center gap-1.5 text-xs fw-semibold py-1.5 px-3">
                    <i class="bi bi-plus-lg"></i>
                    <span>+ Producto</span>
                </a>
            <?php endif; ?>

            <!-- View Public Web Link -->
            <a href="<?= BASE_URL ?>/" target="_blank" class="btn btn-sm btn-light border d-flex align-items-center gap-1.5 py-1.5 px-2.5 text-xs fw-semibold text-dark shadow-xs" title="Abrir catálogo web público">
                <i class="bi bi-globe2 text-primary"></i>
                <span class="d-none d-sm-inline">Web Pública</span>
            </a>

            <div class="vr bg-secondary opacity-25 mx-1" style="height: 22px;"></div>

            <!-- User Dropdown -->
            <div class="dropdown">
                <button class="btn btn-sm btn-light border d-flex align-items-center gap-2 py-1 px-2.5 rounded-3 shadow-xs" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar" style="width: 28px; height: 28px; font-size: 0.8rem;">
                        <?= strtoupper(substr($currentUser['name'] ?? 'U', 0, 1)) ?>
                    </div>
                    <span class="text-dark small fw-bold d-none d-md-inline text-truncate max-w-150">
                        <?= htmlspecialchars($currentUser['name'] ?? 'Usuario') ?>
                    </span>
                    <i class="bi bi-chevron-down text-muted text-xxs"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 text-xs p-2" style="min-width: 230px;">
                    <li class="px-3 py-2 bg-light rounded-2 mb-2">
                        <div class="fw-bold text-dark text-sm text-truncate"><?= htmlspecialchars($currentUser['name'] ?? 'Usuario') ?></div>
                        <div class="text-muted text-xxs text-truncate"><?= htmlspecialchars($currentUser['email'] ?? '') ?></div>
                        <span class="badge bg-primary text-xxs mt-1.5 fw-bold"><?= htmlspecialchars($currentUser['role_name'] ?? 'Usuario') ?></span>
                    </li>
                    <li>
                        <a class="dropdown-item py-1.5 rounded-2 d-flex align-items-center gap-2 text-dark" href="<?= ADMIN_URL ?>/?c=auth&a=profile">
                            <i class="bi bi-person-gear text-primary"></i>
                            <span>Mi Perfil y Contraseña</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-1.5 rounded-2 d-flex align-items-center gap-2 text-dark" href="<?= BASE_URL ?>/" target="_blank">
                            <i class="bi bi-box-arrow-up-right text-info"></i>
                            <span>Ver Tienda / Catálogo</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item py-1.5 rounded-2 d-flex align-items-center gap-2 text-danger fw-semibold" href="<?= ADMIN_URL ?>/?c=auth&a=logout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Cerrar Sesión</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- CONTENT WRAPPER -->
<main class="admin-content">
