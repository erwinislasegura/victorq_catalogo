<?php
/**
 * Vista de Detalle de Producto Individual (Product Detail Page)
 * Estilo Oficial Corporativo VICTORQ (Paleta #015B91, Geometría Rectangular Industrial)
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($product['model']) ?> - <?= htmlspecialchars($product['name']) ?> | <?= APP_NAME ?></title>
<meta name="description" content="<?= htmlspecialchars(substr(strip_tags($product['description'] ?? ''), 0, 160)) ?>">

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
        <li><a href="<?= BASE_URL ?>/#catalogo">Catálogo</a></li>
        <li><a href="<?= BASE_URL ?>/#recursos">Herramientas de Selección</a></li>
        <li><a href="<?= BASE_URL ?>/contact.php">Contacto</a></li>
      </ul>

      <div class="nav-actions-group">
        <a href="<?= BASE_URL ?>/#catalogo" class="btn btn-victorq-dark" style="padding: 9px 16px; font-size: 0.76rem;">
          <i class="bi bi-arrow-left"></i>
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
      <a href="<?= BASE_URL ?>/category.php?slug=<?= htmlspecialchars($product['category_slug'] ?? 'llaves') ?>" style="color: #015B91;">
        <?= htmlspecialchars($product['category_name'] ?? 'Líneas de Productos') ?>
      </a>
      <i class="bi bi-chevron-right" style="font-size: 0.65rem;"></i>
      <span style="color: #111827;"><?= htmlspecialchars($product['model']) ?></span>
    </div>
  </div>
</div>

<!-- PRODUCT HERO DETAIL SECTION -->
<section style="padding: 50px 0 60px; background: #ffffff;">
  <div class="contenedor">
    <div style="display: grid; grid-template-columns: 1fr 1.25fr; gap: 48px; align-items: flex-start;" class="product-detail-layout">
      
      <!-- LEFT: Product Photo & Badges -->
      <div>
        <div style="background: #ffffff; border: 1px solid #cdd2d6; padding: 32px; display: flex; align-items: center; justify-content: center; min-height: 380px; position: relative;">
          <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="max-height: 320px; max-width: 100%; object-fit: contain;" onerror="this.src='<?= ASSETS_URL ?>/img/logo.png'">
          
          <div style="position: absolute; top: 12px; left: 12px; display: flex; flex-direction: column; gap: 6px;">
            <span style="background: #015B91; color: #ffffff; font-size: 0.68rem; font-weight: 800; text-transform: uppercase; padding: 3px 8px; font-family: 'Montserrat', sans-serif;">
              700 BAR CERTIFICADO
            </span>
            <span style="background: #111827; color: #38bdf8; font-size: 0.68rem; font-weight: 800; text-transform: uppercase; padding: 3px 8px; font-family: 'Montserrat', sans-serif;">
              STOCK DISPONIBLE
            </span>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 14px;">
          <div style="background: #f4f6f8; border: 1px solid #e5e7eb; padding: 10px; text-align: center;">
            <i class="bi bi-shield-check" style="color: #015B91; font-size: 1.2rem;"></i>
            <div style="font-size: 0.68rem; font-weight: 700; text-transform: uppercase; margin-top: 4px; color: #111827;">ISO 9001:2015</div>
          </div>
          <div style="background: #f4f6f8; border: 1px solid #e5e7eb; padding: 10px; text-align: center;">
            <i class="bi bi-award-fill" style="color: #015B91; font-size: 1.2rem;"></i>
            <div style="font-size: 0.68rem; font-weight: 700; text-transform: uppercase; margin-top: 4px; color: #111827;">Garantía 12M</div>
          </div>
          <div style="background: #f4f6f8; border: 1px solid #e5e7eb; padding: 10px; text-align: center;">
            <i class="bi bi-truck" style="color: #015B91; font-size: 1.2rem;"></i>
            <div style="font-size: 0.68rem; font-weight: 700; text-transform: uppercase; margin-top: 4px; color: #111827;">Entrega Inmediata</div>
          </div>
        </div>
      </div>

      <!-- RIGHT: Product Info & Actions -->
      <div>
        <a href="<?= BASE_URL ?>/category.php?slug=<?= htmlspecialchars($product['category_slug'] ?? 'llaves') ?>" class="text-decoration-none" style="display: inline-block; background: #e8f4fc; color: #015B91; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; padding: 3px 10px; margin-bottom: 10px; letter-spacing: 0.05em;">
          <?= htmlspecialchars($product['category_name'] ?? 'Línea de Equipos') ?>
        </a>

        <h1 style="font-size: 2.3rem; line-height: 1.1; margin-bottom: 6px; text-transform: uppercase; color: #0a1118;">
          <?= htmlspecialchars($product['model']) ?>
        </h1>

        <h2 style="font-size: 1.25rem; font-weight: 700; color: #4b5563; margin-bottom: 18px; font-family: 'Roboto', sans-serif; text-transform: none;">
          <?= htmlspecialchars($product['name']) ?>
        </h2>

        <div style="border-left: 3px solid #015B91; padding-left: 16px; margin-bottom: 24px;">
          <p style="color: #374151; font-size: 0.96rem; line-height: 1.65; margin: 0;">
            <?= nl2br(htmlspecialchars($product['description'] ?? 'Herramienta de grado industrial fabricada bajo rigurosos estándares internacionales para faenas de apernado crítico, minería, generación de energía y plantas petroquímicas.')) ?>
          </p>
        </div>

        <!-- Key Highlights Grid -->
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 28px;">
          <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px 16px;">
            <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: #6b7280; display: block;">Presión Máxima de Trabajo</span>
            <strong style="font-family: 'Roboto Mono', monospace; font-size: 1.1rem; color: #015B91;">700 BAR (10.000 PSI)</strong>
          </div>
          <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px 16px;">
            <span style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: #6b7280; display: block;">Certificación & Calibración</span>
            <strong style="font-size: 0.95rem; color: #111827;">Trazabilidad Individual ISO</strong>
          </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
          <button type="button" class="btn btn-victorq-primary" onclick="agregarAlCarro(<?= (int)$product['id'] ?>)" style="padding: 14px 28px; font-size: 0.88rem;">
            <i class="bi bi-cart-plus-fill"></i>
            <span>Añadir al Carrito</span>
          </button>
          
          <?php if (!empty($product['datasheet_pdf'])): ?>
            <a href="<?= ASSETS_URL ?>/docs/datasheets/<?= htmlspecialchars($product['datasheet_pdf']) ?>" target="_blank" class="btn btn-victorq-dark" style="padding: 14px 22px; font-size: 0.88rem;">
              <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i>
              <span>Ver Ficha Técnica</span>
            </a>
          <?php endif; ?>

          <a href="#cotizar" class="btn btn-outline-dark" style="padding: 14px 20px; font-size: 0.88rem; border-color: #cdd2d6;">
            <i class="bi bi-file-earmark-text"></i>
            <span>Cotizar RFQ</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ENGINEERING SPECIFICATIONS TABLE (Design System Compliant) -->
<section style="padding: 50px 0 60px; background: #f4f6f8; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb;">
  <div class="contenedor">
    <div style="margin-bottom: 24px;">
      <div style="display: inline-block; background: #015B91; color: #ffffff; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; padding: 3px 8px; margin-bottom: 8px; font-family: 'Montserrat', sans-serif;">
        Parámetros Técnicos
      </div>
      <h2 style="font-size: 1.6rem; color: #0a1118; margin: 0; text-transform: uppercase;">
        TABLA DE ESPECIFICACIONES DE INGENIERÍA
      </h2>
      <p style="color: #4b5563; font-size: 0.9rem; margin: 4px 0 0 0;">
        Valores certificados de torque, presión, dimensiones y capacidades de trabajo para <?= htmlspecialchars($product['model']) ?>.
      </p>
    </div>

    <!-- Structured Table Card -->
    <div class="tech-table-card">
      <div class="tech-table-header">
        <h3><i class="bi bi-list-columns-reverse text-info me-2"></i>Ficha Técnica: <?= htmlspecialchars($product['model']) ?> — <?= htmlspecialchars($product['name']) ?></h3>
        <div class="d-flex align-items-center gap-2">
          <?php if (!empty($product['datasheet_pdf'])): ?>
            <a href="<?= ASSETS_URL ?>/docs/datasheets/<?= htmlspecialchars($product['datasheet_pdf']) ?>" target="_blank" class="btn btn-xs btn-outline-light text-xxs fw-bold text-uppercase" style="padding: 4px 10px; font-family: 'Montserrat', sans-serif;">
              <i class="bi bi-download me-1 text-warning"></i> Descargar Documento
            </a>
          <?php endif; ?>
          <span style="font-size: 0.72rem; color: #38bdf8; font-weight: 700; text-transform: uppercase; font-family: 'Montserrat', sans-serif;">
            VICTORQ INDUSTRIAL 700 BAR
          </span>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table-enerpac-dense">
          <thead>
            <tr>
              <th style="width: 35%;">Parámetro / Especificación</th>
              <th>Valor Certificado de Fábrica</th>
              <th style="width: 25%;">Unidad / Observación</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Modelo / Código</td>
              <td style="font-weight: 700; color: #015B91;"><?= htmlspecialchars($product['model']) ?></td>
              <td>Identificador de Serie</td>
            </tr>
            <tr>
              <td>Equipo / Denominación</td>
              <td><?= htmlspecialchars($product['name']) ?></td>
              <td>Herramienta Industrial</td>
            </tr>
            <tr>
              <td>Línea / Categoría</td>
              <td><?= htmlspecialchars($product['category_name'] ?? 'Equipos de Potencia') ?></td>
              <td>Familia de Producto</td>
            </tr>
            <tr>
              <td>Presión Máxima de Trabajo</td>
              <td style="font-weight: 700; color: #015B91;">700 bar / 10.000 psi</td>
              <td>Estándar Hidráulico de Alta Presión</td>
            </tr>

            <!-- Dynamic Specs from Database -->
            <?php if (!empty($product['specs'])): ?>
              <?php foreach ($product['specs'] as $key => $val): ?>
                <tr>
                  <td><?= htmlspecialchars($key) ?></td>
                  <td style="font-weight: 700; color: #0a1118;"><?= htmlspecialchars($val) ?></td>
                  <td>Parámetro de Aplicación</td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>

            <tr>
              <td>Trazabilidad & Calibración</td>
              <td>Certificado Individual de Calibración ISO</td>
              <td>Norma ISO 9001:2015</td>
            </tr>
            <tr>
              <td>Garantía de Fábrica</td>
              <td>12 Meses contra defectos de manufactura</td>
              <td>Respaldo Oficial VICTORQ</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div style="padding: 12px 16px; background: #ffffff; border-top: 1px solid #e5e7eb; font-size: 0.75rem; color: #6b7280;">
        <i class="bi bi-info-circle-fill text-primary me-1"></i> Para dimensionamiento especial en faenas mineras o condiciones extremas, solicite asesoría a nuestro departamento de ingeniería de aplicaciones.
      </div>
    </div>
  </div>
</section>

<?php if (!empty($relatedProducts)): ?>
<!-- PRODUCTOS RELACIONADOS -->
<section style="padding: 40px 0 60px; background: #ffffff; border-top: 1px solid #e5e7eb;">
  <div class="contenedor">
    <div style="border-bottom: 2px solid #015B91; padding-bottom: 8px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-end;">
      <h3 style="font-size: 1.25rem; color: #0a1118; margin: 0; text-transform: uppercase;">
        Equipos Relacionados en esta Línea
      </h3>
      <a href="<?= BASE_URL ?>/category.php?slug=<?= htmlspecialchars($product['category_slug']) ?>" style="font-size: 0.8rem; font-weight: 700; color: #015B91; text-decoration: none;">
        Ver todos <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    <div class="product-cards-grid">
      <?php foreach ($relatedProducts as $rp): ?>
        <div class="product-card">
          <div class="prod-img-box">
            <span class="prod-badge-top"><?= ucfirst($rp['category_slug'] ?? 'Equipo') ?></span>
            <a href="<?= BASE_URL ?>/product.php?id=<?= (int)$rp['id'] ?>">
              <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($rp['image']) ?>" alt="<?= htmlspecialchars($rp['name']) ?>" loading="lazy" onerror="this.src='<?= ASSETS_URL ?>/img/logo.png'">
            </a>
          </div>
          <div class="prod-content">
            <div class="prod-model-code"><?= htmlspecialchars($rp['model']) ?></div>
            <h3 class="prod-title">
              <a href="<?= BASE_URL ?>/product.php?id=<?= (int)$rp['id'] ?>">
                <?= htmlspecialchars($rp['name']) ?>
              </a>
            </h3>

            <div class="prod-actions">
              <button type="button" class="btn-action-cart" onclick="agregarAlCarro(<?= (int)$rp['id'] ?>)">
                <i class="bi bi-cart-plus-fill"></i>
                <span>Añadir al Carrito</span>
              </button>
              <?php if (!empty($rp['datasheet_pdf'])): ?>
                <a href="<?= ASSETS_URL ?>/docs/datasheets/<?= htmlspecialchars($rp['datasheet_pdf']) ?>" target="_blank" class="btn-action-spec">
                  <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                  <span>Ver Ficha Técnica (PDF)</span>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- GLOBAL CORPORATE FOOTER (CENTRALIZADO) -->
<?php require VIEWS_PATH . '/layouts/public_footer.php'; ?>

<script>
const BASE_URL = "<?= BASE_URL ?>";
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= ASSETS_URL ?>/js/catalog.js"></script>

</body>
</html>
