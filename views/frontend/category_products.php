<?php
/**
 * Vista de Categoría Individual (Category Landing Page)
 * Estilo Oficial Corporativo VICTORQ (Paleta #015B91, Geometría Rectangular Industrial)
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($category['name']) ?> | Catálogo Técnico <?= APP_NAME ?></title>
<meta name="description" content="Línea completa de <?= htmlspecialchars($category['name']) ?> para faenas de alto rendimiento, apernado crítico y potencia hidráulica de 700 bar.">

<!-- Fonts: Montserrat, Roboto & Roboto Mono -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Roboto:wght@400;500;700&family=Roboto+Mono:wght@500;700&display=swap" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Custom Industrial Catalog CSS -->
<link rel="stylesheet" href="<?= ASSETS_URL ?>/css/catalog.css">

<link rel="shortcut icon" href="<?= ASSETS_URL ?>/img/logo.png" type="image/png">
</head>
<body>

<!-- VICTORQ BLUE TOP ACCENT LINE -->
<div class="top-stripe-victorq"></div>

<!-- HEADER -->
<header class="header-enerpac">
  <!-- Top Utility Bar -->
  <div class="top-utility-bar">
    <div class="contenedor">
      <div class="d-flex align-items-center flex-wrap">
        <span><i class="bi bi-telephone-fill"></i> Atención Técnica: <strong><?= APP_PHONE ?></strong></span>
        <span><i class="bi bi-envelope-fill"></i> <?= APP_EMAIL ?></span>
        <span class="d-none d-md-inline"><i class="bi bi-patch-check-fill"></i> Calibración ISO 9001:2015</span>
      </div>
      <div class="d-flex align-items-center gap-3">
        <span class="d-none d-lg-inline"><i class="bi bi-shield-check"></i> Distribuidor Oficial Autorizado</span>
        <a href="<?= ADMIN_URL ?>/" class="link-backend-top text-decoration-none">
          <i class="bi bi-lock-fill me-1"></i> Portal Clientes / Backend
        </a>
      </div>
    </div>
  </div>

  <!-- Main Navbar -->
  <div class="contenedor">
    <nav class="navbar-enerpac">
      <div class="brand-box">
        <a href="<?= BASE_URL ?>/" class="d-flex align-items-center">
          <img src="<?= ASSETS_URL ?>/img/logo.png" alt="<?= APP_NAME ?>">
        </a>
      </div>

      <ul class="nav-menu-list">
        <li><a href="<?= BASE_URL ?>/#departamentos">Líneas de Productos</a></li>
        <li><a href="<?= BASE_URL ?>/#catalogo">Catálogo Completo</a></li>
        <li><a href="<?= BASE_URL ?>/#recursos">Herramientas de Selección</a></li>
        <li><a href="<?= BASE_URL ?>/contact.php">Contacto</a></li>
      </ul>

      <div class="nav-actions-group">
        <a href="<?= BASE_URL ?>/#catalogo" class="btn btn-victorq-dark" style="padding: 9px 16px; font-size: 0.76rem;">
          <i class="bi bi-grid-fill"></i>
          <span>Catálogo</span>
        </a>
        <a class="btn btn-victorq-dark" href="<?= BASE_URL ?>/cart.php" style="padding: 8px 14px; font-size: 0.78rem;">
          <i class="bi bi-cart3 text-warning"></i>
          <span>Carro (<strong class="cart-count-badge">0</strong>)</span>
        </a>
        <a class="btn btn-victorq-primary" href="<?= BASE_URL ?>/contact.php" style="padding: 8px 14px; font-size: 0.78rem;">
          <i class="bi bi-telephone-fill"></i>
          <span>Contacto</span>
        </a>
      </div>
    </nav>
  </div>
</header>

<!-- BREADCRUMB -->
<div style="background: #f4f6f8; border-bottom: 1px solid #e5e7eb; padding: 12px 0;">
  <div class="contenedor">
    <div class="d-flex align-items-center gap-2 text-xs" style="color: #6b7280; font-weight: 600; text-transform: uppercase;">
      <a href="<?= BASE_URL ?>/" style="color: #015B91;">Inicio</a>
      <i class="bi bi-chevron-right" style="font-size: 0.65rem;"></i>
      <a href="<?= BASE_URL ?>/#departamentos" style="color: #015B91;">Líneas de Productos</a>
      <i class="bi bi-chevron-right" style="font-size: 0.65rem;"></i>
      <span style="color: #111827;"><?= htmlspecialchars($category['name']) ?></span>
    </div>
  </div>
</div>

<!-- CATEGORY HERO SECTION -->
<section style="background-color: #0a1118; background-image: linear-gradient(to right, rgba(10, 17, 24, 0.96) 0%, rgba(10, 17, 24, 0.85) 60%, rgba(10, 17, 24, 0.5) 100%), url('<?= ASSETS_URL ?>/img/banners/hero_industrial_torque.jpg'); background-size: cover; background-position: center; color: #ffffff; padding: 75px 0 65px; border-bottom: 4px solid #015B91;">
  <div class="contenedor">
    <div style="max-width: 780px;">
      <div class="hero-tag">
        <i class="bi <?= htmlspecialchars($category['icon'] ?: 'bi-tools') ?> me-1"></i> Línea Industrial Especializada
      </div>
      <h1 style="font-size: 2.5rem; line-height: 1.1; margin-bottom: 14px; text-transform: uppercase; color: #ffffff;">
        <?= htmlspecialchars($category['name']) ?>
      </h1>
      <p style="color: #cbd5e1; font-size: 1.02rem; line-height: 1.6; margin-bottom: 26px;">
        <?= htmlspecialchars($category['description'] ?? 'Equipos de alto rendimiento y potencia hidráulica de 700 bar diseñados para aplicaciones críticas y exigentes en minería, energía y petroquímica.') ?>
      </p>

      <!-- Category KPI Stats Strip -->
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; border-top: 2px solid rgba(1, 91, 145, 0.5); padding-top: 18px;">
        <div>
          <strong style="display: block; font-family: 'Montserrat', sans-serif; font-size: 1.5rem; font-weight: 900; color: #38bdf8; line-height: 1.1;"><?= count($products) ?> MODELOS</strong>
          <span style="font-size: 0.7rem; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">Disponibles en Catálogo</span>
        </div>
        <div>
          <strong style="display: block; font-family: 'Montserrat', sans-serif; font-size: 1.5rem; font-weight: 900; color: #38bdf8; line-height: 1.1;">700 BAR</strong>
          <span style="font-size: 0.7rem; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">Presión de Operación</span>
        </div>
        <div>
          <strong style="display: block; font-family: 'Montserrat', sans-serif; font-size: 1.5rem; font-weight: 900; color: #38bdf8; line-height: 1.1;">ISO 9001</strong>
          <span style="font-size: 0.7rem; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600;">Trazabilidad Certificada</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CATEGORY SWITCHER BAR -->
<section style="background: #ffffff; border-bottom: 1px solid #e5e7eb; padding: 14px 0; position: sticky; top: 68px; z-index: 900; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
  <div class="contenedor">
    <div style="display: flex; gap: 6px; overflow-x: auto; padding-bottom: 4px;" class="category-tab-bar mb-0">
      <a href="<?= BASE_URL ?>/#catalogo" class="cat-tab-button text-decoration-none">
        <i class="bi bi-grid-fill"></i> Todos los Equipos
      </a>
      <?php foreach ($allCategories as $cat): ?>
        <?php $isActive = ($cat['slug'] === $category['slug']); ?>
        <a href="<?= BASE_URL ?>/category.php?slug=<?= htmlspecialchars($cat['slug']) ?>" class="cat-tab-button text-decoration-none <?= $isActive ? 'active' : '' ?>">
          <i class="bi <?= htmlspecialchars($cat['icon'] ?: 'bi-tag') ?>"></i> <?= htmlspecialchars($cat['name']) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- PRODUCTS GRID FOR THIS CATEGORY -->
<section style="padding: 55px 0 70px; background: #f8fafc;">
  <div class="contenedor">
    <div class="section-headline d-flex justify-content-between align-items-end flex-wrap gap-3">
      <div>
        <h2>EQUIPOS EN: <?= htmlspecialchars($category['name']) ?></h2>
        <p>Seleccione cualquier modelo para consultar su ficha técnica de ingeniería y tabla de especificaciones completa.</p>
      </div>
      <div class="text-xs text-muted fw-bold">
        Mostrando <?= count($products) ?> equipos
      </div>
    </div>

    <?php if (!empty($products)): ?>
      <div class="products-layout-grid">
        <?php foreach ($products as $p): 
          $specs = is_array($p['specs_json'] ?? null) ? $p['specs_json'] : (json_decode($p['specs_json'] ?? '{}', true) ?: []);
        ?>
          <div class="prod-item-card">
            <a href="<?= BASE_URL ?>/product.php?id=<?= (int)$p['id'] ?>" class="prod-item-img text-decoration-none">
              <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" loading="lazy" onerror="this.src='<?= ASSETS_URL ?>/img/logo.png'">
            </a>
            <div class="prod-item-body">
              <span class="prod-cat-badge"><?= htmlspecialchars($category['name']) ?></span>
              <div class="prod-model-title"><?= htmlspecialchars($p['model']) ?></div>
              <h3>
                <a href="<?= BASE_URL ?>/product.php?id=<?= (int)$p['id'] ?>" style="color: inherit; text-decoration: none;">
                  <?= htmlspecialchars($p['name']) ?>
                </a>
              </h3>
              
              <ul class="prod-spec-table">
                <?php $c = 0; foreach ($specs as $k => $v): if ($c++ >= 4) break; ?>
                  <li>
                    <span><?= htmlspecialchars($k) ?></span>
                    <span><?= htmlspecialchars($v) ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>

              <div class="prod-actions">
                <button type="button" class="btn-action-cart" onclick="agregarAlCarro(<?= (int)$p['id'] ?>)">
                  <i class="bi bi-cart-plus-fill"></i>
                  <span>Añadir al Carrito</span>
                </button>
                <?php if (!empty($p['datasheet_pdf'])): ?>
                  <a href="<?= ASSETS_URL ?>/docs/datasheets/<?= htmlspecialchars($p['datasheet_pdf']) ?>" target="_blank" class="btn-action-spec">
                    <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                    <span>Ver Ficha Técnica (PDF)</span>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div style="background: #ffffff; border: 1px solid #cdd2d6; padding: 40px; text-align: center;">
        <i class="bi bi-box-seam" style="font-size: 2.5rem; color: #6b7280;"></i>
        <h4 style="margin-top: 12px; color: #111827;">No hay equipos registrados actualmente en esta categoría</h4>
        <p style="color: #6b7280; font-size: 0.88rem; margin-bottom: 20px;">Estamos actualizando nuestro catálogo técnico con nuevas series y modelos de fábrica.</p>
        <a href="<?= BASE_URL ?>/#catalogo" class="btn btn-victorq-primary">
          <span>Ver Otros Equipos Disponibles</span>
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- CATEGORY CAPABILITIES & APPLICATION GUIDELINES -->
<section style="padding: 60px 0; background: #ffffff; border-top: 1px solid #e5e7eb;">
  <div class="contenedor">
    <div class="section-headline">
      <h2>VENTAJAS Y CRITERIOS DE INGENIERÍA</h2>
      <p>Factores clave de rendimiento y seguridad para la línea <?= htmlspecialchars($category['name']) ?>.</p>
    </div>

    <div class="tools-4grid">
      <div class="tool-box-card">
        <div>
          <h4>CALIBRACIÓN CON TRAZABILIDAD</h4>
          <p>Todos los equipos de esta línea se entregan con protocolo de prueba y certificado de calibración individual.</p>
        </div>
        <div style="font-size: 0.72rem; color: #38bdf8; font-weight: 700; text-transform: uppercase;">
          <i class="bi bi-patch-check-fill me-1"></i> Norma ISO 9001
        </div>
      </div>

      <div class="tool-box-card">
        <div>
          <h4>COMPATIBILIDAD 700 BAR</h4>
          <p>Conexiones estándar con acoples rápidos de alto caudal y mangueras con factor de seguridad 4:1.</p>
        </div>
        <div style="font-size: 0.72rem; color: #38bdf8; font-weight: 700; text-transform: uppercase;">
          <i class="bi bi-shield-lock-fill me-1"></i> Seguridad Certificada
        </div>
      </div>

      <div class="tool-box-card">
        <div>
          <h4>SERVICIO TÉCNICO EN FAENA</h4>
          <p>Disponibilidad de repuestos originales, sellos, mangueras y asistencia técnica 24/7 en terreno.</p>
        </div>
        <div style="font-size: 0.72rem; color: #38bdf8; font-weight: 700; text-transform: uppercase;">
          <i class="bi bi-tools me-1"></i> Soporte Especializado
        </div>
      </div>

      <div class="tool-box-card">
        <div>
          <h4>DIMENSIONAMIENTO A MEDIDA</h4>
          <p>Nuestros ingenieros calculan el modelo exacto para sus pernos, bridas, cargas o espacios reducidos.</p>
        </div>
        <a href="<?= BASE_URL ?>/contact.php" class="tool-link">Solicitar Asesoría <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- GLOBAL CORPORATE FOOTER (CENTRALIZADO) -->
<?php require VIEWS_PATH . '/layouts/public_footer.php'; ?>

<script>
const BASE_URL = "<?= BASE_URL ?>";
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= ASSETS_URL ?>/js/catalog.js"></script>

</body>
</html>
