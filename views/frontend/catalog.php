<?php
/**
 * Vista Principal del Catálogo Público Web VICTORQ
 * Estilo Oficial Enerpac (https://www.enerpac.com/en-us/home)
 * Geometría industrial rectangular rigurosa, fotografía de alto impacto y arquitectura de catálogo pesado.
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= APP_NAME ?> | Potencia Hidráulica y Herramientas de Torque de 700 Bar</title>
<meta name="description" content="Línea completa de herramientas para apernado crítico y potencia hidráulica de 700 bar: llaves de torque, bombas, cilindros y cortatuercas.">

<!-- Fonts: Montserrat, Roboto & Roboto Mono for Official Enerpac Industrial Feel -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Roboto:wght@400;500;700&family=Roboto+Mono:wght@500;700&display=swap" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Custom Enerpac-Style Catalog CSS -->
<link rel="stylesheet" href="<?= ASSETS_URL ?>/css/catalog.css">

<link rel="shortcut icon" href="<?= ASSETS_URL ?>/img/logo.png" type="image/png">
</head>
<body>

<!-- ENERPAC YELLOW TOP STRIPE -->
<div class="top-stripe-enerpac"></div>

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
        <li><a href="#departamentos">Líneas de Productos</a></li>
        <li><a href="#catalogo">Catálogo</a></li>
        <li><a href="#recursos">Herramientas de Selección</a></li>
        <li><a href="<?= BASE_URL ?>/contact.php">Contacto</a></li>
      </ul>

      <div class="nav-actions-group">
        <div class="search-input-wrapper d-none d-sm-flex">
          <i class="bi bi-search"></i>
          <input type="text" id="buscador-global" placeholder="Buscar modelo o serie...">
        </div>
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

<!-- HERO SECTION (Full-Bleed Industrial Photo Banner) -->
<section class="hero-enerpac-photo">
  <div class="contenedor">
    <div class="hero-box">
      <div class="hero-tag">
        <i class="bi bi-lightning-charge-fill me-1"></i> Potencia Hidráulica 700 Bar & Apernado Crítico
      </div>
      <h1>SOLUCIONES DE POTENCIA. <span>FUERZA INDUSTRIAL.</span></h1>
      <p>
        Línea pesada de llaves de torque de cuadrante y bajo perfil, centrales electrohidráulicas de 700 bar y cilindros de levante pesado de hasta 1.000 toneladas para minería, energía y petroquímica.
      </p>

      <div class="hero-buttons">
        <a class="btn btn-enerpac-yellow" href="#catalogo">
          <span>Explorar Catálogo</span>
          <i class="bi bi-arrow-right"></i>
        </a>
        <a class="btn btn-enerpac-outline-white" href="<?= BASE_URL ?>/contact.php">
          <i class="bi bi-telephone-fill"></i>
          <span>Asistencia en Faena</span>
        </a>
      </div>

      <!-- Technical KPI Stats Strip -->
      <div class="hero-stats-strip">
        <div class="stat-item">
          <strong>700 BAR</strong>
          <span>Presión Certificada</span>
        </div>
        <div class="stat-item">
          <strong>37.000</strong>
          <span>Lb-pie Torque Máx.</span>
        </div>
        <div class="stat-item">
          <strong>1.000 TON</strong>
          <span>Levante Hidráulico</span>
        </div>
        <div class="stat-item">
          <strong>24 LÍNEAS</strong>
          <span>Equipos en Stock</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- VISUAL DEPARTMENT TILES (Enerpac Department Cards with Product Photos) -->
<section class="section-department-tiles" id="departamentos">
  <div class="contenedor">
    <div class="section-headline">
      <h2>LÍNEAS DE PRODUCTOS INDUSTRIALES</h2>
      <p>Seleccione una categoría técnica para ver modelos, especificaciones y dimensiones de ingeniería.</p>
    </div>

    <div class="dept-grid">
      <!-- 1. Llaves de Torque -->
      <a href="<?= BASE_URL ?>/category.php?slug=llaves" class="dept-card text-decoration-none">
        <div class="dept-img-container">
          <img src="<?= ASSETS_URL ?>/img/products/prod_01_llaves.png" alt="Llaves de Torque">
        </div>
        <div class="dept-info">
          <h4>LLAVES DE TORQUE HIDRÁULICAS</h4>
          <i class="bi bi-arrow-right-square-fill"></i>
        </div>
      </a>

      <!-- 2. Bombas y Centrales -->
      <a href="<?= BASE_URL ?>/category.php?slug=bombas" class="dept-card text-decoration-none">
        <div class="dept-img-container">
          <img src="<?= ASSETS_URL ?>/img/products/prod_05_bombas.png" alt="Bombas 700 Bar">
        </div>
        <div class="dept-info">
          <h4>BOMBAS Y CENTRALES 700 BAR</h4>
          <i class="bi bi-arrow-right-square-fill"></i>
        </div>
      </a>

      <!-- 3. Cilindros y Gatas -->
      <a href="<?= BASE_URL ?>/category.php?slug=cilindros" class="dept-card text-decoration-none">
        <div class="dept-img-container">
          <img src="<?= ASSETS_URL ?>/img/products/prod_09_cilindros.png" alt="Cilindros de Levante">
        </div>
        <div class="dept-info">
          <h4>CILINDROS Y GATAS DE LEVANTE</h4>
          <i class="bi bi-arrow-right-square-fill"></i>
        </div>
      </a>

      <!-- 4. Corta Tuercas -->
      <a href="<?= BASE_URL ?>/category.php?slug=cortatuercas" class="dept-card text-decoration-none">
        <div class="dept-img-container">
          <img src="<?= ASSETS_URL ?>/img/products/prod_19_cortatuercas.png" alt="Corta Tuercas">
        </div>
        <div class="dept-info">
          <h4>CORTA TUERCAS HIDRÁULICOS</h4>
          <i class="bi bi-arrow-right-square-fill"></i>
        </div>
      </a>

      <!-- 5. Herramientas de Bridas -->
      <a href="<?= BASE_URL ?>/category.php?slug=bridas" class="dept-card text-decoration-none">
        <div class="dept-img-container">
          <img src="<?= ASSETS_URL ?>/img/products/prod_16_bridas.png" alt="Herramientas de Bridas">
        </div>
        <div class="dept-info">
          <h4>HERRAMIENTAS PARA BRIDAS</h4>
          <i class="bi bi-arrow-right-square-fill"></i>
        </div>
      </a>

      <!-- 6. Extractores y Prensas -->
      <a href="<?= BASE_URL ?>/category.php?slug=extractores" class="dept-card text-decoration-none">
        <div class="dept-img-container">
          <img src="<?= ASSETS_URL ?>/img/products/prod_21_extractores.png" alt="Extractores">
        </div>
        <div class="dept-info">
          <h4>EXTRACTORES Y PRENSAS</h4>
          <i class="bi bi-arrow-right-square-fill"></i>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- SELECTION TOOLS & ENGINEERING RESOURCES (Enerpac 4-Block Resource Grid) -->
<section class="section-selection-tools" id="recursos">
  <div class="contenedor">
    <div class="section-headline">
      <h2>HERRAMIENTAS DE SELECCIÓN E INGENIERÍA</h2>
      <p>Recursos técnicos para calcular rangos de torque, selección de cilindros y tablas de apernado.</p>
    </div>

    <div class="tools-4grid">
      <div class="tool-box-card">
        <div>
          <h4>TABLAS DE APERNADO & TORQUE</h4>
          <p>Tablas de torque recomendado según calidad de pernos ASTM, ISO y diámetros de hexágono.</p>
        </div>
        <a href="#catalogo" class="tool-link">Ver Equipos de Torque <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="tool-box-card">
        <div>
          <h4>GUÍA DE TONELAJE DE CILINDROS</h4>
          <p>Cálculo de fuerza efectiva, carrera requerida y compatibilidad con bombas de simple y doble efecto.</p>
        </div>
        <a href="#catalogo" class="tool-link">Ver Cilindros <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="tool-box-card">
        <div>
          <h4>SEPARADORES DE BRIDAS (FLANGE GURU)</h4>
          <p>Dimensionamiento de separación mecánica e hidráulica para mantenimiento de tuberías y sellos.</p>
        </div>
        <a href="#catalogo" class="tool-link">Ver Separadores <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="tool-box-card">
        <div>
          <h4>DIMENSIONAMIENTO DE CENTRALES 700 BAR</h4>
          <p>Cálculo de caudales por etapa para optimizar tiempos de ciclo en apriete continuo de bridas.</p>
        </div>
        <a href="<?= BASE_URL ?>/contact.php" class="tool-link">Solicitar Asesoría <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- PRODUCT CATALOG SECTION (Sharp High-Precision Enerpac Cards) -->
<section class="section-catalog-grid" id="catalogo">
  <div class="contenedor">
    <div class="section-headline">
      <h2>CATÁLOGO TÉCNICO DE EQUIPOS</h2>
      <p>Consulte las fichas técnicas, capacidades y especificaciones de cada familia de equipos.</p>
    </div>

    <!-- Category Tab Bar -->
    <div class="category-tab-bar" id="pestanas-categorias">
      <button class="cat-tab-button active" data-cat="todos">
        <i class="bi bi-grid-fill"></i> Todos (<?= count($products) ?>)
      </button>
      <?php foreach ($categories as $cat): ?>
        <button class="cat-tab-button" data-cat="<?= htmlspecialchars($cat['slug']) ?>">
          <i class="bi <?= htmlspecialchars($cat['icon'] ?: 'bi-tag') ?>"></i> <?= htmlspecialchars($cat['name']) ?>
        </button>
      <?php endforeach; ?>
    </div>

    <!-- Products Grid -->
    <div class="products-layout-grid" id="contenedor-productos">
      <?php foreach ($products as $p): 
        $specs = is_array($p['specs_json']) ? $p['specs_json'] : (json_decode($p['specs_json'] ?? '{}', true) ?: []);
      ?>
        <div class="prod-item-card" data-cat="<?= htmlspecialchars($p['category_slug'] ?? 'llaves') ?>" data-search="<?= strtolower(htmlspecialchars($p['model'] . ' ' . $p['name'])) ?>">
          <a href="<?= BASE_URL ?>/product.php?id=<?= (int)$p['id'] ?>" class="prod-item-img text-decoration-none">
            <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" loading="lazy" onerror="this.src='<?= ASSETS_URL ?>/img/logo.png'">
          </a>
          <div class="prod-item-body">
            <a href="<?= BASE_URL ?>/category.php?slug=<?= htmlspecialchars($p['category_slug'] ?? 'llaves') ?>" class="prod-cat-badge text-decoration-none">
              <?= htmlspecialchars($p['category_name'] ?? ucfirst($p['category_slug'] ?? 'Equipo')) ?>
            </a>
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
  </div>
</section>

<!-- HEAVY SOLUTIONS APPLICATION BANNER (Wide Photo Banner) -->
<section class="section-heavy-solutions">
  <div class="contenedor">
    <div class="solutions-content">
      <div class="hero-tag mb-2">Ingeniería en Terreno & Gran Tonelaje</div>
      <h2>SOLUCIONES DE LEVANTE PESADO Y <span>APERNADO CRÍTICO</span></h2>
      <p>
        Suministramos sistemas hidráulicos síncronos de levante para puentes, palas mineras, molinos SAG y reactores petroquímicos con control de presión milimétrico y certificación de carga.
      </p>
      <div class="d-flex gap-3">
        <a class="btn btn-enerpac-yellow" href="<?= BASE_URL ?>/contact.php">
          <span>Solicitar Asesoría en Terreno</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- GLOBAL CORPORATE FOOTER (CENTRALIZADO) -->
<?php require VIEWS_PATH . '/layouts/public_footer.php'; ?>

<!-- MODAL FICHA TECNICA -->
<div class="overlay-modal" id="overlay-modal">
  <div class="modal-dialog-box">
    <button class="btn-close-box" onclick="cerrarFicha()">&times;</button>
    <div id="contenido-ficha"></div>
  </div>
</div>

<!-- JS Data & Logic -->
<script>
const productsData = <?= json_encode($products, JSON_UNESCAPED_UNICODE) ?>;
const categoriesData = <?= json_encode($categories, JSON_UNESCAPED_UNICODE) ?>;
const ASSETS_URL = "<?= ASSETS_URL ?>";
const BASE_URL = "<?= BASE_URL ?>";

function filtrarCategoria(catSlug) {
  const btn = document.querySelector(`.cat-tab-button[data-cat="${catSlug}"]`);
  if (btn) {
    btn.click();
    document.getElementById('catalogo')?.scrollIntoView({ behavior: 'smooth' });
  }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= ASSETS_URL ?>/js/catalog.js"></script>

</body>
</html>
