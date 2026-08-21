<?php
/**
 * Barra Lateral Dinámica y Organizada (Sidebar)
 * Agrupación lógica por áreas de negocio y permisos RBAC
 */
$currentModule = strtolower($_GET['c'] ?? 'dashboard');

// Mapeo de módulos por secciones lógicas
$menuSections = [
    'PANEL & REPORTES' => [
        'icon' => 'bi-pie-chart-fill',
        'modules' => ['dashboard']
    ],
    'COMERCIAL & VENTAS' => [
        'icon' => 'bi-briefcase-fill',
        'modules' => ['quote', 'quotes', 'contact', 'contacts', 'payment_config', 'payment', 'flow', 'checkout']
    ],
    'CATÁLOGO & ALMACÉN' => [
        'icon' => 'bi-box-seam-fill',
        'modules' => ['product', 'products', 'category', 'categories', 'inventory', 'table', 'tables']
    ],
    'SISTEMA & ACCESOS' => [
        'icon' => 'bi-gear-fill',
        'modules' => ['user', 'users', 'role', 'roles', 'menu', 'menus']
    ]
];

// Indexar menús permitidos del usuario
$userMenuMap = [];
if (!empty($userMenus)) {
    foreach ($userMenus as $m) {
        $code = strtolower($m['module_code'] ?? '');
        $userMenuMap[$code] = $m;
    }
}
?>
<!-- SIDEBAR -->
<aside class="admin-sidebar" id="sidebar">
    <!-- Brand Logo Header -->
    <div class="sidebar-brand">
        <a href="<?= ADMIN_URL ?>/?c=dashboard" class="brand-link">
            <img src="<?= ASSETS_URL ?>/img/logo.png" alt="<?= APP_NAME ?>" class="brand-logo-img">
            <span class="brand-badge-tag">ADMIN</span>
        </a>
        <button class="btn btn-sm btn-link text-white-50 d-lg-none p-0" id="sidebarCloseBtn" type="button">
            <i class="bi bi-x-lg fs-5"></i>
        </button>
    </div>

    <!-- Dynamic Menu Navigation Grouped by Section (Sin bloque de usuario redundante) -->
    <div class="sidebar-nav pt-2">
        <?php 
        $renderedModules = [];
        foreach ($menuSections as $sectionTitle => $secData): 
            $sectionItems = [];
            foreach ($secData['modules'] as $modCode) {
                if (isset($userMenuMap[$modCode])) {
                    $sectionItems[$modCode] = $userMenuMap[$modCode];
                    $renderedModules[$modCode] = true;
                }
            }
            if (empty($sectionItems)) continue;
        ?>
            <div class="nav-section-title">
                <i class="bi <?= $secData['icon'] ?>"></i>
                <span><?= $sectionTitle ?></span>
            </div>
            <ul class="nav nav-pills flex-column list-unstyled mb-2">
                <?php foreach ($sectionItems as $modCode => $m): 
                    $isActive = ($currentModule === $modCode) || 
                                ($currentModule === 'dashboard' && $modCode === 'dashboard') ||
                                ($currentModule === 'quotes' && $modCode === 'quote') ||
                                ($currentModule === 'contacts' && $modCode === 'contact');
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
            </ul>
        <?php endforeach; ?>

        <!-- Any remaining custom menus -->
        <?php 
        $otherMenus = [];
        if (!empty($userMenus)) {
            foreach ($userMenus as $m) {
                $code = strtolower($m['module_code'] ?? '');
                if (!isset($renderedModules[$code])) {
                    $otherMenus[] = $m;
                }
            }
        }
        if (!empty($otherMenus)):
        ?>
            <div class="nav-section-title">
                <i class="bi bi-three-dots"></i>
                <span>OTROS MÓDULOS</span>
            </div>
            <ul class="nav nav-pills flex-column list-unstyled mb-2">
                <?php foreach ($otherMenus as $m): 
                    $isActive = ($currentModule === strtolower($m['module_code']));
                    $menuUrl = str_starts_with($m['url'], 'http') || str_starts_with($m['url'], '../') ? $m['url'] : ADMIN_URL . '/' . $m['url'];
                    $iconClass = $m['icon'] ?: 'bi-circle';
                    if (!str_starts_with($iconClass, 'bi-')) $iconClass = 'bi-' . $iconClass;
                ?>
                    <li class="nav-item">
                        <a href="<?= htmlspecialchars($menuUrl) ?>" class="nav-link <?= $isActive ? 'active' : '' ?>">
                            <div class="nav-link-content">
                                <span class="nav-link-icon"><i class="bi <?= htmlspecialchars($iconClass) ?>"></i></span>
                                <span class="nav-link-text"><?= htmlspecialchars($m['title']) ?></span>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
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
