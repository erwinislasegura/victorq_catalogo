<?php
$pageTitle = 'Dashboard Corporativo';

// Cargar métricas adicionales de inventario y contactos para el dashboard
$inventoryModel = new Inventory();
$invKpis = $inventoryModel->getKpiMetrics();

$contactModel = new Contact();
$contactCounts = $contactModel->getCountsByStatus();
?>

<!-- WELCOME BANNER MODERNO -->
<div class="card shadow-sm border-0 rounded-3 bg-corporate-header text-white mb-4 overflow-hidden position-relative" style="background: linear-gradient(135deg, #0A1118 0%, #013a5e 100%) !important;">
    <div class="card-body p-4 position-relative" style="z-index: 2;">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-warning text-dark fw-bold text-xxs px-2 py-1">PANEL VICTORQ v<?= APP_VERSION ?></span>
                    <span class="text-white-50 text-xxs font-monospace"><i class="bi bi-calendar3 me-1"></i> <?= date('d/m/Y') ?></span>
                </div>
                <h4 class="fw-bold mb-1 font-montserrat text-white">
                    ¡Bienvenido(a), <?= htmlspecialchars($currentUser['name'] ?? 'Administrador') ?>!
                </h4>
                <p class="text-white-50 small mb-0" style="max-width: 680px; line-height: 1.5;">
                    Centro de mando para la administración del catálogo de potencia hidráulica de 700 bar, emisión de presupuestos técnicos, control de existencias en bodega y pasarela de pagos.
                </p>
            </div>
            
            <!-- Quick Actions Buttons -->
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <?php if (Auth::can('quotes', 'create')): ?>
                    <a href="<?= ADMIN_URL ?>/?c=quote&a=create" class="btn btn-warning btn-sm fw-bold d-flex align-items-center gap-1.5 shadow-sm px-3 py-2">
                        <i class="bi bi-file-earmark-plus-fill"></i> + Nueva Cotización
                    </a>
                <?php endif; ?>
                <?php if (Auth::can('products', 'create')): ?>
                    <a href="<?= ADMIN_URL ?>/?c=product&a=create" class="btn btn-outline-light btn-sm fw-semibold d-flex align-items-center gap-1.5 px-3 py-2">
                        <i class="bi bi-plus-circle"></i> + Producto
                    </a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>/" target="_blank" class="btn btn-light btn-sm fw-semibold d-flex align-items-center gap-1.5 px-3 py-2 text-dark">
                    <i class="bi bi-globe2 text-primary"></i> Tienda Web
                </a>
            </div>
        </div>
    </div>
</div>

<!-- KPI METRICS ROW -->
<div class="row g-3 mb-4">
    <!-- Total Productos -->
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 rounded-3 bg-white h-100 kpi-card kpi-primary">
            <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-xs fw-bold text-muted text-uppercase tracking-wider">Catálogo de Equipos</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1 fs-4"><?= (int)$stats['total_products'] ?></h3>
                    <small class="text-success text-xs fw-semibold"><i class="bi bi-check-circle-fill me-1"></i><?= (int)$stats['active_products'] ?> activos en web</small>
                </div>
                <div class="kpi-icon-box bg-primary-subtle text-primary">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Cotizaciones Pendientes -->
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 rounded-3 bg-white h-100 kpi-card kpi-warning">
            <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-xs fw-bold text-muted text-uppercase tracking-wider">Cotizaciones Pendientes</span>
                    <h3 class="fw-bold text-warning-emphasis mb-0 mt-1 fs-4"><?= (int)$stats['pending_quotes'] ?></h3>
                    <small class="text-muted text-xs"><i class="bi bi-clock-history me-1"></i><?= (int)$stats['total_quotes'] ?> emitidas en total</small>
                </div>
                <div class="kpi-icon-box bg-warning-subtle text-warning-emphasis">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Existencias en Bodega -->
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 rounded-3 bg-white h-100 kpi-card kpi-success">
            <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-xs fw-bold text-muted text-uppercase tracking-wider">Stock en Bodega</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1 fs-4"><?= number_format($invKpis['total_units'], 0, ',', '.') ?></h3>
                    <small class="text-primary text-xs fw-semibold">Valor: $<?= number_format($invKpis['total_valuation'], 0, ',', '.') ?> CLP</small>
                </div>
                <div class="kpi-icon-box bg-success-subtle text-success">
                    <i class="bi bi-boxes"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes de Contacto -->
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 rounded-3 bg-white h-100 kpi-card kpi-danger">
            <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-xs fw-bold text-muted text-uppercase tracking-wider">Mensajes Web</span>
                    <h3 class="fw-bold text-danger mb-0 mt-1 fs-4"><?= (int)($contactCounts['unread'] ?? 0) ?></h3>
                    <small class="text-muted text-xs"><i class="bi bi-envelope-check me-1"></i><?= (int)($contactCounts['total'] ?? 0) ?> recibidos</small>
                </div>
                <div class="kpi-icon-box bg-danger-subtle text-danger">
                    <i class="bi bi-envelope-paper-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN WORKSPACE: RECENT ACTIVITY & QUICK WIDGETS -->
<div class="row g-4">
    <!-- COLUMNA PRINCIPAL (Últimas Cotizaciones) -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-text text-primary"></i>
                    <span>Solicitudes y Presupuestos Técnicos Recientes</span>
                </h6>
                <a href="<?= ADMIN_URL ?>/?c=quote" class="btn btn-sm btn-outline-primary text-xs fw-bold py-1 px-2.5">
                    Ver Listado Completo &rarr;
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0 text-xs">
                        <thead class="table-light text-uppercase text-xxs text-muted">
                            <tr>
                                <th class="ps-3 py-2.5">Cliente / Empresa</th>
                                <th>Requerimiento / Equipos</th>
                                <th>Fecha</th>
                                <th class="text-center">Estado</th>
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
                                            <div class="fw-bold text-dark"><?= htmlspecialchars($q['client_name']) ?></div>
                                            <small class="text-muted text-xxs"><?= htmlspecialchars($q['company'] ?: $q['client_email']) ?></small>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block fw-semibold text-primary" style="max-width: 220px;" title="<?= htmlspecialchars($q['product_interest'] ?? '') ?>">
                                                <?= htmlspecialchars($q['product_interest'] ?: ($q['product_name'] ?? 'Equipos')) ?>
                                            </span>
                                        </td>
                                        <td class="text-muted font-monospace text-xxs">
                                            <?= date('d/m/Y H:i', strtotime($q['created_at'])) ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $statusBadges[$q['status']] ?? '<span class="badge bg-secondary">N/A</span>' ?>
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?= ADMIN_URL ?>/?c=quote&a=view&id=<?= $q['id'] ?>" class="btn btn-xs btn-outline-primary" title="Ver Detalle">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= BASE_URL ?>/quote_pdf.php?quote_id=<?= $q['id'] ?>" target="_blank" class="btn btn-xs btn-outline-danger" title="Ver PDF">
                                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No hay solicitudes de cotización recientes.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- COLUMNA LATERAL (Alertas de Bodega & Atajos) -->
    <div class="col-lg-4">
        <!-- Widget: Estado de Inventario -->
        <div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-pie-chart-fill text-primary"></i>
                    <span>Estado del Almacén</span>
                </h6>
                <a href="<?= ADMIN_URL ?>/?c=inventory" class="text-xs text-primary text-decoration-none fw-bold">Gestionar</a>
            </div>
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center p-2 rounded-2 bg-success-subtle mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        <div>
                            <span class="fw-bold text-success d-block text-xs">Existencias Óptimas</span>
                            <small class="text-muted text-xxs">Sobre el stock mínimo</small>
                        </div>
                    </div>
                    <strong class="text-success fs-6"><?= $invKpis['optimal_count'] ?></strong>
                </div>

                <div class="d-flex justify-content-between align-items-center p-2 rounded-2 bg-warning-subtle mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill text-warning-emphasis fs-5"></i>
                        <div>
                            <span class="fw-bold text-warning-emphasis d-block text-xs">Stock Crítico (Reponer)</span>
                            <small class="text-muted text-xxs">&le; Umbral de seguridad</small>
                        </div>
                    </div>
                    <strong class="text-warning-emphasis fs-6"><?= $invKpis['critical_count'] ?></strong>
                </div>

                <div class="d-flex justify-content-between align-items-center p-2 rounded-2 bg-danger-subtle">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                        <div>
                            <span class="fw-bold text-danger d-block text-xs">Equipos Agotados</span>
                            <small class="text-muted text-xxs">Sin existencias (0)</small>
                        </div>
                    </div>
                    <strong class="text-danger fs-6"><?= $invKpis['out_of_stock_count'] ?></strong>
                </div>
            </div>
        </div>

        <!-- Widget: Atajos Frecuentes -->
        <div class="card shadow-sm border-0 rounded-3 bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-grid-fill text-primary"></i>
                    <span>Atajos Rápidos de Gestión</span>
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-2">
                    <div class="col-6">
                        <a href="<?= ADMIN_URL ?>/?c=product" class="p-3 border rounded-3 text-center text-decoration-none d-block bg-light text-dark h-100 hover-shadow transition">
                            <i class="bi bi-box-seam fs-3 text-primary d-block mb-1"></i>
                            <span class="fw-bold text-xs d-block">Catálogo</span>
                            <small class="text-muted text-xxs">Productos</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= ADMIN_URL ?>/?c=inventory&a=kardex" class="p-3 border rounded-3 text-center text-decoration-none d-block bg-light text-dark h-100 hover-shadow transition">
                            <i class="bi bi-clock-history fs-3 text-info d-block mb-1"></i>
                            <span class="fw-bold text-xs d-block">Kardex</span>
                            <small class="text-muted text-xxs">Movimientos</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= ADMIN_URL ?>/?c=payment_config" class="p-3 border rounded-3 text-center text-decoration-none d-block bg-light text-dark h-100 hover-shadow transition">
                            <i class="bi bi-credit-card-2-front fs-3 text-success d-block mb-1"></i>
                            <span class="fw-bold text-xs d-block">Flow.cl</span>
                            <small class="text-muted text-xxs">Pasarela</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= ADMIN_URL ?>/?c=contact" class="p-3 border rounded-3 text-center text-decoration-none d-block bg-light text-dark h-100 hover-shadow transition">
                            <i class="bi bi-envelope-paper fs-3 text-warning d-block mb-1"></i>
                            <span class="fw-bold text-xs d-block">Contactos</span>
                            <small class="text-muted text-xxs">Mensajes Web</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
