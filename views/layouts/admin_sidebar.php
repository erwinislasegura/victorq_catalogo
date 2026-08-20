<?php
/**
 * Barra Lateral Dinámica (Sidebar) según Permisos RBAC
 */
$currentModule = $_GET['c'] ?? 'dashboard';
?>
<!-- SIDEBAR -->
<aside class="admin-sidebar" id="sidebar">
    <!-- Brand Logo Header -->
    <div class="sidebar-brand">
        <a href="<?= ADMIN_URL ?>/?c=dashboard" class="d-flex align-items-center text-decoration-none text-white gap-2 text-truncate">
            <div class="brand-logo-badge">
                <img src="<?= ASSETS_URL ?>/img/logo.png" alt="<?= APP_NAME ?>">
            </div>
            <span class="fs-6 fw-bold tracking-wider text-white text-truncate">
                VICTORQ <span class="badge bg-warning text-dark text-xxs px-1.5 py-0.5">ADMIN</span>
            </span>
        </a>
        <button class="btn btn-sm btn-link text-white-50 d-lg-none p-0" id="sidebarCloseBtn" type="button">
            <i class="bi bi-x-lg fs-5"></i>
        </button>
    </div>

    <!-- User Mini Profile -->
    <div class="sidebar-user">
        <div class="user-avatar">
            <?= strtoupper(substr($currentUser['name'] ?? 'U', 0, 1)) ?>
        </div>
        <div class="user-info text-truncate" style="min-width: 0;">
            <div class="fw-semibold text-white small text-truncate"><?= htmlspecialchars($currentUser['name'] ?? 'Usuario') ?></div>
            <span class="badge badge-role text-xxs text-truncate d-inline-block max-w-150"><?= htmlspecialchars($currentUser['role_name'] ?? 'Sin Rol') ?></span>
        </div>
    </div>

    <!-- Dynamic Menu Navigation -->
    <div class="sidebar-nav">
        <div class="nav-section-title">Menú Principal</div>
        <ul class="nav nav-pills flex-column list-unstyled mb-0">
            <?php if (!empty($userMenus)): ?>
                <?php foreach ($userMenus as $m): 
                    $isActive = ($currentModule === strtolower($m['module_code'])) || 
                                ($currentModule === 'dashboard' && $m['module_code'] === 'dashboard');
                    $menuUrl = str_starts_with($m['url'], 'http') || str_starts_with($m['url'], '../') 
                                ? $m['url'] 
                                : ADMIN_URL . '/' . $m['url'];
                    $target = str_starts_with($m['url'], '../') ? 'target="_blank"' : '';
                    
                    $iconClass = $m['icon'] ?: 'bi-circle';
                    if (!str_starts_with($iconClass, 'bi-')) {
                        $iconClass = 'bi-' . $iconClass;
                    }
                ?>
                <li class="nav-item">
                    <a href="<?= htmlspecialchars($menuUrl) ?>" class="nav-link <?= $isActive ? 'active' : '' ?>" <?= $target ?>>
                        <div class="nav-link-content">
                            <span class="nav-link-icon"><i class="bi <?= htmlspecialchars($iconClass) ?>"></i></span>
                            <span class="nav-link-text"><?= htmlspecialchars($m['title']) ?></span>
                        </div>
                        <?php if (!empty($m['badge'])): ?>
                            <span class="badge <?= htmlspecialchars($m['badge_class'] ?? 'bg-primary') ?> text-xxs px-1.5 py-0.5"><?= htmlspecialchars($m['badge']) ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="nav-item">
                    <a href="<?= ADMIN_URL ?>/?c=dashboard" class="nav-link active">
                        <div class="nav-link-content">
                            <span class="nav-link-icon"><i class="bi bi-speedometer2"></i></span>
                            <span class="nav-link-text">Dashboard</span>
                        </div>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <a href="<?= ADMIN_URL ?>/?c=auth&a=profile" class="btn btn-outline-light text-nowrap" title="Mi Perfil">
            <i class="bi bi-person-gear"></i> <span>Perfil</span>
        </a>
        <a href="<?= ADMIN_URL ?>/?c=auth&a=logout" class="btn btn-outline-danger text-nowrap" title="Cerrar Sesión">
            <i class="bi bi-box-arrow-right"></i> <span>Salir</span>
        </a>
    </div>
</aside>

<!-- MAIN CONTENT WRAPPER -->
<div class="admin-main">
