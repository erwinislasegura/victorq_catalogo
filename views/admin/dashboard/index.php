<?php
$pageTitle = 'Dashboard Corporativo';
?>

<!-- WELCOME BANNER -->
<div class="card shadow-sm border-0 rounded-3 bg-corporate-header text-white mb-4 overflow-hidden">
    <div class="card-body p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <div class="badge bg-warning text-dark fw-bold text-xs mb-2">Panel de Administración v<?= APP_VERSION ?></div>
            <h4 class="fw-bold mb-1">Bienvenido(a), <?= htmlspecialchars($currentUser['name'] ?? 'Usuario') ?></h4>
            <p class="text-white-50 small mb-0">Gestión de catálogo industrial, control de cotizaciones y permisos de acceso para VICTORQ.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <?php if (Auth::can('products', 'create')): ?>
                <a href="<?= ADMIN_URL ?>/?c=product&a=create" class="btn btn-warning btn-sm fw-semibold d-flex align-items-center gap-1.5 shadow-xs">
                    <i class="bi bi-plus-circle"></i> Nuevo Producto
                </a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/index.php" target="_blank" class="btn btn-outline-light btn-sm fw-semibold d-flex align-items-center gap-1.5">
                <i class="bi bi-eye"></i> Ver Catálogo Web
            </a>
        </div>
    </div>
</div>

<!-- KPI METRICS ROW -->
<div class="row g-3 mb-4">
    <!-- Total Productos -->
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 rounded-3 bg-white h-100 kpi-card">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-xs fw-semibold text-muted text-uppercase tracking-wider">Productos en Catálogo</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1"><?= (int)$stats['total_products'] ?></h3>
                    <small class="text-success text-xs"><i class="bi bi-check2-circle"></i> <?= (int)$stats['active_products'] ?> activos</small>
                </div>
                <div class="kpi-icon bg-info-subtle text-info rounded-3 p-3">
                    <i class="bi bi-box-seam fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Categorías -->
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 rounded-3 bg-white h-100 kpi-card">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-xs fw-semibold text-muted text-uppercase tracking-wider">Categorías Activas</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1"><?= (int)$stats['total_categories'] ?></h3>
                    <small class="text-primary text-xs"><i class="bi bi-tags"></i> Líneas industriales</small>
                </div>
                <div class="kpi-icon bg-primary-subtle text-primary rounded-3 p-3">
                    <i class="bi bi-grid fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Cotizaciones Pendientes -->
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 rounded-3 bg-white h-100 kpi-card">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-xs fw-semibold text-muted text-uppercase tracking-wider">Cotizaciones Pendientes</span>
                    <h3 class="fw-bold text-danger mb-0 mt-1"><?= (int)$stats['pending_quotes'] ?></h3>
                    <small class="text-danger text-xs"><i class="bi bi-exclamation-circle"></i> Requieren atención</small>
                </div>
                <div class="kpi-icon bg-danger-subtle text-danger rounded-3 p-3">
                    <i class="bi bi-clock-history fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Cotizaciones -->
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 rounded-3 bg-white h-100 kpi-card">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-xs fw-semibold text-muted text-uppercase tracking-wider">Total Cotizaciones</span>
                    <h3 class="fw-bold text-success mb-0 mt-1"><?= (int)$stats['total_quotes'] ?></h3>
                    <small class="text-success text-xs"><i class="bi bi-check-all"></i> <?= (int)$stats['quoted_quotes'] ?> cotizadas</small>
                </div>
                <div class="kpi-icon bg-success-subtle text-success rounded-3 p-3">
                    <i class="bi bi-file-earmark-text fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Latest Quotes Table -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3 bg-white h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-envelope-paper text-primary"></i> Solicitudes de Cotización Recientes
                </h6>
                <a href="<?= ADMIN_URL ?>/?c=quote" class="btn btn-sm btn-link text-decoration-none text-xs fw-semibold p-0">Ver todas &rarr;</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0 text-xs">
                        <thead class="table-light text-uppercase text-xxs text-muted">
                            <tr>
                                <th class="ps-3 py-2">Cliente / Empresa</th>
                                <th>Interés / Producto</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th class="text-end pe-3">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($latestQuotes)): ?>
                                <?php foreach ($latestQuotes as $q): 
                                    $statusBadges = [
                                        'pending' => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle">Pendiente</span>',
                                        'in_review' => '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">En Revisión</span>',
                                        'quoted' => '<span class="badge bg-success-subtle text-success border border-success-subtle">Cotizado</span>',
                                        'closed' => '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Cerrado</span>',
                                    ];
                                ?>
                                <tr>
                                    <td class="ps-3 py-2.5">
                                        <div class="fw-semibold text-dark"><?= htmlspecialchars($q['client_name']) ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($q['company'] ?: $q['client_email']) ?></small>
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block max-w-200" title="<?= htmlspecialchars($q['product_interest']) ?>">
                                            <?= htmlspecialchars($q['product_interest'] ?: ($q['product_name'] ?? 'General')) ?>
                                        </span>
                                    </td>
                                    <td class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($q['created_at'])) ?>
                                    </td>
                                    <td>
                                        <?= $statusBadges[$q['status']] ?? '<span class="badge bg-secondary">N/A</span>' ?>
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="<?= ADMIN_URL ?>/?c=quote&a=view&id=<?= $q['id'] ?>" class="btn btn-xs btn-outline-primary py-0.5 px-2" title="Ver Detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No hay solicitudes de cotización registradas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Status Breakdown & Recent Products -->
    <div class="col-lg-4">
        <!-- Quotes Status Summary Card -->
        <div class="card shadow-sm border-0 rounded-3 bg-white mb-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-pie-chart text-warning"></i> Estado de Cotizaciones
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2 text-xs">
                    <span class="d-flex align-items-center gap-2"><span class="badge-dot bg-danger"></span> Pendientes:</span>
                    <strong class="text-dark"><?= $quoteCounts['pending'] ?? 0 ?></strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2 text-xs">
                    <span class="d-flex align-items-center gap-2"><span class="badge-dot bg-warning"></span> En Revisión:</span>
                    <strong class="text-dark"><?= $quoteCounts['in_review'] ?? 0 ?></strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2 text-xs">
                    <span class="d-flex align-items-center gap-2"><span class="badge-dot bg-success"></span> Cotizadas:</span>
                    <strong class="text-dark"><?= $quoteCounts['quoted'] ?? 0 ?></strong>
                </div>
                <div class="d-flex justify-content-between align-items-center text-xs">
                    <span class="d-flex align-items-center gap-2"><span class="badge-dot bg-secondary"></span> Cerradas:</span>
                    <strong class="text-dark"><?= $quoteCounts['closed'] ?? 0 ?></strong>
                </div>
            </div>
        </div>

        <!-- System Quick Info Card -->
        <div class="card shadow-sm border-0 rounded-3 bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle text-info"></i> Información del Sistema
                </h6>
            </div>
            <div class="card-body p-3 text-xs text-muted">
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span>Base de Datos:</span>
                    <span class="badge bg-success-subtle text-success">Conectada MySQL</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span>Roles Configurados:</span>
                    <strong class="text-dark">4 Roles (RBAC)</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span>Tablas Técnicas:</span>
                    <strong class="text-dark"><?= (int)$stats['total_tables'] ?> tablas</strong>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span>Servidor:</span>
                    <strong class="text-dark"><?= htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'PHP ' . phpversion()) ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>
