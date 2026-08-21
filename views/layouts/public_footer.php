<?php
/**
 * Componente Centralizado de Pie de Página (Footer Público)
 * Utilizado de manera homogénea en todas las páginas públicas del catálogo VICTORQ
 */
?>
<!-- GLOBAL CORPORATE FOOTER (CENTRALIZADO) -->
<footer class="global-enerpac-footer">
  <div class="contenedor">
    <div class="footer-4col">
      <!-- 1. IDENTIDAD CORPORATIVA -->
      <div>
        <img src="<?= ASSETS_URL ?>/img/logo.png" alt="<?= APP_NAME ?>" height="38" class="mb-3" style="filter: brightness(0) invert(1);">
        <p class="text-xs text-muted mb-3" style="line-height: 1.6; color: #94a3b8 !important;">
          Especialistas en soluciones integrales de torque de alta precisión, potencia hidráulica de 700 bar y apernado crítico para la gran industria, celulosa y minería.
        </p>
        <div class="text-xs text-white-50 d-flex align-items-center gap-1.5" style="color: #cbd5e1 !important;">
          <i class="bi bi-shield-check text-warning fs-6"></i>
          <span>Calibración y banco de pruebas bajo norma ISO 9001:2015.</span>
        </div>
      </div>

      <!-- 2. LÍNEAS DE EQUIPOS -->
      <div>
        <h4>Líneas de Equipos</h4>
        <ul>
          <li><a href="<?= BASE_URL ?>/category.php?slug=llaves">Llaves de Torque Cuadrante</a></li>
          <li><a href="<?= BASE_URL ?>/category.php?slug=llaves">Llaves de Bajo Perfil</a></li>
          <li><a href="<?= BASE_URL ?>/category.php?slug=bombas">Bombas y Centrales 700 bar</a></li>
          <li><a href="<?= BASE_URL ?>/category.php?slug=cilindros">Cilindros de Levante Pesado</a></li>
          <li><a href="<?= BASE_URL ?>/category.php?slug=multiplicadores">Multiplicadores de Torque</a></li>
        </ul>
      </div>

      <!-- 3. HERRAMIENTAS Y ACCESORIOS -->
      <div>
        <h4>Herramientas Especiales</h4>
        <ul>
          <li><a href="<?= BASE_URL ?>/category.php?slug=bridas">Separadores de Bridas</a></li>
          <li><a href="<?= BASE_URL ?>/category.php?slug=cortatuercas">Corta Tuercas Hidráulicos</a></li>
          <li><a href="<?= BASE_URL ?>/category.php?slug=extractores">Extractores Autocentrantes</a></li>
          <li><a href="<?= BASE_URL ?>/category.php?slug=prensas">Prensas de Taller Hidráulicas</a></li>
          <li><a href="<?= BASE_URL ?>/category.php?slug=accesorios">Manómetros y Mangueras 700 bar</a></li>
        </ul>
      </div>

      <!-- 4. ENLACES Y ATENCIÓN DIRECTA -->
      <div>
        <h4>Enlaces Corporativos</h4>
        <ul>
          <li><a href="<?= BASE_URL ?>/#catalogo"><i class="bi bi-grid-fill me-1 text-primary"></i> Catálogo Completo</a></li>
          <li><a href="<?= BASE_URL ?>/cart.php"><i class="bi bi-cart3 me-1 text-primary"></i> Carro de Compras & Cotizador</a></li>
          <li><a href="<?= BASE_URL ?>/contact.php"><i class="bi bi-envelope-fill me-1 text-primary"></i> Contacto y Asistencia Técnica</a></li>
          <li><a href="<?= ADMIN_URL ?>/"><i class="bi bi-lock-fill text-warning me-1"></i> Acceso Portal Backend</a></li>
        </ul>
        <div class="mt-3 pt-2" style="border-top: 1px solid rgba(255,255,255,0.1);">
          <span style="font-size: 0.72rem; color: #94a3b8; display: block;">Mesa Central / WhatsApp:</span>
          <a href="tel:<?= APP_PHONE ?>" style="color: #ffffff; font-weight: 700; font-family: 'Roboto Mono', monospace; font-size: 0.82rem; text-decoration: none;">
            <i class="bi bi-telephone-fill text-success me-1"></i> <?= APP_PHONE ?>
          </a>
        </div>
      </div>
    </div>

    <!-- FILA INFERIOR -->
    <div class="footer-bottom-row">
      <div>
        &copy; <?= date('Y') ?> <strong><?= APP_COMPANY ?></strong> — Todos los derechos reservados.
      </div>
      <div>
        Diseño Industrial Inspirado en Estándares Globales de Potencia Hidráulica 700 Bar.
      </div>
    </div>
  </div>
</footer>
