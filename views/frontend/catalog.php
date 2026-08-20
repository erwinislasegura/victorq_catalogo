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
        <li><a href="#cotizar">Cotizador RFQ</a></li>
      </ul>

      <div class="nav-actions-group">
        <div class="search-input-wrapper d-none d-sm-flex">
          <i class="bi bi-search"></i>
          <input type="text" id="buscador-global" placeholder="Buscar modelo o serie...">
        </div>
        <a class="btn btn-enerpac-yellow" href="#cotizar">
          <i class="bi bi-file-earmark-text-fill"></i>
          <span>Cotizar Equipos</span>
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
        <a class="btn btn-enerpac-outline-white" href="#cotizar">
          <i class="bi bi-envelope-fill"></i>
          <span>Contactar Ingeniero</span>
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
      <div class="dept-card" onclick="filtrarCategoria('llaves')">
        <div class="dept-img-container">
          <img src="<?= ASSETS_URL ?>/img/products/prod_01_llaves.png" alt="Llaves de Torque">
        </div>
        <div class="dept-info">
          <h4>LLAVES DE TORQUE HIDRÁULICAS</h4>
          <i class="bi bi-arrow-right-square-fill"></i>
        </div>
      </div>

      <!-- 2. Bombas y Centrales -->
      <div class="dept-card" onclick="filtrarCategoria('bombas')">
        <div class="dept-img-container">
          <img src="<?= ASSETS_URL ?>/img/products/prod_05_bombas.png" alt="Bombas 700 Bar">
        </div>
        <div class="dept-info">
          <h4>BOMBAS Y CENTRALES 700 BAR</h4>
          <i class="bi bi-arrow-right-square-fill"></i>
        </div>
      </div>

      <!-- 3. Cilindros y Gatas -->
      <div class="dept-card" onclick="filtrarCategoria('cilindros')">
        <div class="dept-img-container">
          <img src="<?= ASSETS_URL ?>/img/products/prod_09_cilindros.png" alt="Cilindros de Levante">
        </div>
        <div class="dept-info">
          <h4>CILINDROS Y GATAS DE LEVANTE</h4>
          <i class="bi bi-arrow-right-square-fill"></i>
        </div>
      </div>

      <!-- 4. Corta Tuercas -->
      <div class="dept-card" onclick="filtrarCategoria('cortatuercas')">
        <div class="dept-img-container">
          <img src="<?= ASSETS_URL ?>/img/products/prod_19_cortatuercas.png" alt="Corta Tuercas">
        </div>
        <div class="dept-info">
          <h4>CORTA TUERCAS HIDRÁULICOS</h4>
          <i class="bi bi-arrow-right-square-fill"></i>
        </div>
      </div>

      <!-- 5. Herramientas de Bridas -->
      <div class="dept-card" onclick="filtrarCategoria('bridas')">
        <div class="dept-img-container">
          <img src="<?= ASSETS_URL ?>/img/products/prod_16_bridas.png" alt="Herramientas de Bridas">
        </div>
        <div class="dept-info">
          <h4>HERRAMIENTAS PARA BRIDAS</h4>
          <i class="bi bi-arrow-right-square-fill"></i>
        </div>
      </div>

      <!-- 6. Extractores y Prensas -->
      <div class="dept-card" onclick="filtrarCategoria('extractores')">
        <div class="dept-img-container">
          <img src="<?= ASSETS_URL ?>/img/products/prod_21_extractores.png" alt="Extractores">
        </div>
        <div class="dept-info">
          <h4>EXTRACTORES Y PRENSAS</h4>
          <i class="bi bi-arrow-right-square-fill"></i>
        </div>
      </div>
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
        <a href="#cotizar" class="tool-link">Solicitar Asesoría <i class="bi bi-arrow-right"></i></a>
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
          <div class="prod-item-img">
            <img src="<?= ASSETS_URL ?>/img/products/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" loading="lazy" onerror="this.src='<?= ASSETS_URL ?>/img/logo.png'">
          </div>
          <div class="prod-item-body">
            <span class="prod-cat-badge"><?= htmlspecialchars($p['category_name'] ?? ucfirst($p['category_slug'] ?? 'Equipo')) ?></span>
            <div class="prod-model-title"><?= htmlspecialchars($p['model']) ?></div>
            <h3><?= htmlspecialchars($p['name']) ?></h3>
            
            <ul class="prod-spec-table">
              <?php $c = 0; foreach ($specs as $k => $v): if ($c++ >= 4) break; ?>
                <li>
                  <span><?= htmlspecialchars($k) ?></span>
                  <span><?= htmlspecialchars($v) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>

            <div class="prod-actions">
              <button type="button" class="btn-action-spec" onclick="abrirFicha(<?= (int)$p['id'] ?>)">
                <i class="bi bi-file-earmark-text"></i> Ficha Técnica
              </button>
              <button type="button" class="btn-action-quote" onclick="seleccionarProductoCotizar('<?= htmlspecialchars($p['model']) ?> - <?= htmlspecialchars($p['name']) ?>')">
                <i class="bi bi-cart-plus"></i> Cotizar
              </button>
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
        <a class="btn btn-enerpac-yellow" href="#cotizar">
          <span>Solicitar Asesoría en Terreno</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>
</section>


<!-- QUOTATION & RFQ SECTION (Split Form with Industrial Background) -->
<section class="section-rfq-inquiry" id="cotizar">
  <div class="contenedor">
    <div class="rfq-grid-2">
      <!-- Left Info -->
      <div class="rfq-info-col">
        <div class="hero-tag mb-2">Solicitud de Cotización (RFQ)</div>
        <h2>SOLICITE ASESORÍA TÉCNICA Y COTIZACIÓN INMEDIATA</h2>
        <p>
          Complete el formulario con el requerimiento de su proyecto o faena y un ingeniero de aplicaciones VICTORQ se pondrá en contacto para dimensionar la mejor solución técnica.
        </p>

        <ul class="rfq-contact-box">
          <li>
            <i class="bi bi-geo-alt-fill"></i>
            <div>
              <strong class="d-block text-white">Casa Matriz & Laboratorio de Calibración</strong>
              <span>Santiago, Chile (Cobertura y asistencia nacional en faena)</span>
            </div>
          </li>
          <li>
            <i class="bi bi-telephone-fill"></i>
            <div>
              <strong class="d-block text-white">Línea Directa de Ingeniería</strong>
              <span><?= APP_PHONE ?></span>
            </div>
          </li>
          <li>
            <i class="bi bi-envelope-fill"></i>
            <div>
              <strong class="d-block text-white">Correo Comercial & Licitaciones</strong>
              <span><?= APP_EMAIL ?></span>
            </div>
          </li>
          <li>
            <i class="bi bi-patch-check-fill"></i>
            <div>
              <strong class="d-block text-white">Calibración Certificada ISO 9001:2015</strong>
              <span>Protocolos y certificados de trazabilidad individualizados</span>
            </div>
          </li>
        </ul>
      </div>

      <!-- Right Form -->
      <div class="rfq-form-panel">
        <h4 class="fw-bold mb-3" style="color: #000000; border-bottom: 2px solid var(--enerpac-yellow); padding-bottom: 8px;">
          FORMULARIO DE COTIZACIÓN TÉCNICA
        </h4>
        <form id="form-cotizacion" method="POST">
          <div class="form-2col">
            <div class="form-group-enerpac">
              <label for="nombre">Nombre Completo *</label>
              <input type="text" id="nombre" name="nombre" required placeholder="Juan Pérez">
            </div>
            <div class="form-group-enerpac">
              <label for="empresa">Empresa / Faena *</label>
              <input type="text" id="empresa" name="empresa" required placeholder="Minera / Contratista">
            </div>
          </div>

          <div class="form-2col">
            <div class="form-group-enerpac">
              <label for="email">Correo Electrónico *</label>
              <input type="email" id="email" name="email" required placeholder="juan.perez@empresa.cl">
            </div>
            <div class="form-group-enerpac">
              <label for="telefono">Teléfono / Celular *</label>
              <input type="text" id="telefono" name="telefono" required placeholder="+56 9 1234 5678">
            </div>
          </div>

          <div class="form-group-enerpac">
            <label for="categoria">Línea o Equipo de Interés</label>
            <select id="categoria" name="categoria">
              <option value="Consulta General">-- Seleccionar Línea de Equipos --</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat['name']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group-enerpac">
            <label for="mensaje">Detalle del Requerimiento Técnico</label>
            <textarea id="mensaje" name="mensaje" rows="4" placeholder="Indique modelo de interés, rango de torque requerido, diámetro de pernos, tonelaje o condiciones de faena..."></textarea>
          </div>

          <button type="submit" class="btn btn-enerpac-yellow w-100" id="btn-enviar-cotizacion" style="padding: 14px;">
            <i class="bi bi-send-fill"></i>
            <span>Enviar Solicitud de Cotización</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- GLOBAL CORPORATE FOOTER -->
<footer class="global-enerpac-footer">
  <div class="contenedor">
    <div class="footer-4col">
      <div>
        <img src="<?= ASSETS_URL ?>/img/logo.png" alt="<?= APP_NAME ?>" height="38" class="mb-3" style="filter: brightness(0) invert(1);">
        <p class="text-xs text-muted mb-3">
          Especialistas en soluciones integrales de torque de alta precisión, potencia hidráulica de 700 bar y apernado crítico para la gran industria y minería.
        </p>
        <div class="text-xs text-white-50">
          <i class="bi bi-shield-check text-warning me-1"></i> Calibración certificada bajo norma ISO 9001:2015.
        </div>
      </div>

      <div>
        <h4>Líneas de Equipos</h4>
        <ul>
          <li><a href="#catalogo">Llaves de Torque Cuadrante</a></li>
          <li><a href="#catalogo">Llaves de Bajo Perfil</a></li>
          <li><a href="#catalogo">Bombas y Centrales 700 bar</a></li>
          <li><a href="#catalogo">Cilindros de Levante Pesado</a></li>
          <li><a href="#catalogo">Multiplicadores de Torque</a></li>
        </ul>
      </div>

      <div>
        <h4>Herramientas Especiales</h4>
        <ul>
          <li><a href="#catalogo">Separadores de Bridas</a></li>
          <li><a href="#catalogo">Corta Tuercas Hidráulicos</a></li>
          <li><a href="#catalogo">Extractores Autocentrantes</a></li>
          <li><a href="#catalogo">Prensas de Taller</a></li>
          <li><a href="#catalogo">Manómetros y Mangueras 700 bar</a></li>
        </ul>
      </div>

      <div>
        <h4>Enlaces Corporativos</h4>
        <ul>
          <li><a href="<?= ADMIN_URL ?>/"><i class="bi bi-lock-fill text-warning me-1"></i> Acceso Portal Backend</a></li>
          <li><a href="#catalogo">Catálogo Completo</a></li>
          <li><a href="#recursos">Herramientas de Selección</a></li>
          <li><a href="#cotizar">Contacto Directo</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom-row">
      <div>
        &copy; <?= date('Y') ?> <strong><?= APP_COMPANY ?></strong> — Todos los derechos reservados.
      </div>
      <div>
        Diseño Industrial Inspirado en Estándares Globales de Potencia Hidráulica.
      </div>
    </div>
  </div>
</footer>

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
