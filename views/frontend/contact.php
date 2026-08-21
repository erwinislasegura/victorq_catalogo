<?php
/**
 * Vista Pública de Contacto y Asistencia Técnica
 * Estilo Oficial Corporativo VICTORQ (Paleta #015B91, #00A3E0, #0A1118)
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contacto & Asistencia Técnica | <?= APP_NAME ?></title>

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
<body style="background: #f4f6f8;">

<div class="top-stripe-victorq"></div>

<!-- HEADER -->
<header class="header-enerpac">
  <div class="top-utility-bar">
    <div class="contenedor">
      <div class="d-flex align-items-center flex-wrap">
        <span><i class="bi bi-shield-check"></i> Asistencia Técnica y Calibración en Terreno</span>
        <span><i class="bi bi-telephone-fill"></i> Central: <strong><?= APP_PHONE ?></strong></span>
        <span class="d-none d-md-inline"><i class="bi bi-envelope-fill"></i> <?= APP_EMAIL ?></span>
      </div>
      <div class="d-flex align-items-center gap-3">
        <a href="<?= ADMIN_URL ?>/" class="link-backend-top text-decoration-none">
          <i class="bi bi-lock-fill me-1"></i> Portal Backend
        </a>
      </div>
    </div>
  </div>

  <div class="contenedor">
    <nav class="navbar-enerpac">
      <div class="brand-box">
        <a href="<?= BASE_URL ?>/" class="d-flex align-items-center">
          <img src="<?= ASSETS_URL ?>/img/logo.png" alt="<?= APP_NAME ?>">
        </a>
      </div>

      <ul class="nav-menu-list">
        <li><a href="<?= BASE_URL ?>/#departamentos">Líneas de Productos</a></li>
        <li><a href="<?= BASE_URL ?>/#catalogo">Catálogo de Equipos</a></li>
        <li><a href="<?= BASE_URL ?>/#recursos">Herramientas de Selección</a></li>
        <li><a href="<?= BASE_URL ?>/contact.php" class="active">Contacto</a></li>
      </ul>

      <div class="nav-actions-group">
        <a class="btn btn-victorq-dark" href="<?= BASE_URL ?>/cart.php" style="padding: 8px 14px; font-size: 0.78rem;">
          <i class="bi bi-cart3 text-warning"></i>
          <span>Carro (<strong class="cart-count-badge">0</strong>)</span>
        </a>
        <a class="btn btn-victorq-primary" href="<?= BASE_URL ?>/#catalogo">
          <i class="bi bi-grid-fill"></i>
          <span>Ver Catálogo</span>
        </a>
      </div>
    </nav>
  </div>
</header>

<!-- BREADCRUMB -->
<div style="background: #ffffff; border-bottom: 1px solid #e5e7eb; padding: 10px 0;">
  <div class="contenedor">
    <div class="d-flex align-items-center gap-2 text-xs" style="color: #6b7280; font-weight: 600; text-transform: uppercase;">
      <a href="<?= BASE_URL ?>/" style="color: #015B91; text-decoration: none;">Inicio</a>
      <i class="bi bi-chevron-right" style="font-size: 0.65rem;"></i>
      <span style="color: #111827;">Contacto & Asistencia Técnica</span>
    </div>
  </div>
</div>

<!-- CONTENIDO PRINCIPAL DE CONTACTO -->
<section style="padding: 40px 0 80px; min-height: 75vh;">
  <div class="contenedor">
    
    <div style="margin-bottom: 32px;">
      <div style="display: inline-block; background: #015B91; color: #ffffff; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; padding: 3px 8px; margin-bottom: 8px; font-family: 'Montserrat', sans-serif;">
        Atención Comercial & Soporte Técnico
      </div>
      <h1 style="font-size: 2.1rem; color: #0a1118; margin: 0; text-transform: uppercase;">
        CENTRO DE CONTACTO & ASISTENCIA EN TERRENO
      </h1>
      <p style="color: #4b5563; font-size: 0.95rem; margin: 6px 0 0 0; max-width: 780px;">
        Póngase en contacto con nuestro equipo de ingenieros especialistas para consultas comerciales, cotizaciones a medida, asesoría en faenas mineras o calibración de herramientas de 700 bar.
      </p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1.35fr; gap: 36px; align-items: flex-start;" class="rfq-grid-2">
      
      <!-- COLUMNA IZQUIERDA: INFORMACIÓN CORPORATIVA Y CANALES -->
      <div>
        <div style="background: #ffffff; border: 1px solid #cdd2d6; border-top: 4px solid #0a1118; padding: 28px; margin-bottom: 24px;">
          <h3 style="font-size: 1.15rem; color: #0a1118; margin-bottom: 18px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; text-transform: uppercase;">
            Canales de Atención Directa
          </h3>

          <ul class="list-unstyled d-flex flex-column gap-3 mb-0 text-sm">
            <li class="d-flex align-items-start gap-3">
              <div style="width: 38px; height: 38px; background: #eff6ff; border: 1px solid #bfdbfe; color: #015B91; display: flex; align-items: center; justify-content: center; border-radius: 2px; flex-shrink: 0;">
                <i class="bi bi-geo-alt-fill fs-5"></i>
              </div>
              <div>
                <strong style="color: #0a1118; font-family: 'Montserrat', sans-serif; text-transform: uppercase; font-size: 0.8rem; display: block;">Casa Matriz & Laboratorio:</strong>
                <span style="color: #475569; font-size: 0.88rem;">Av. Industrial 4500, Santiago de Chile</span>
              </div>
            </li>

            <li class="d-flex align-items-start gap-3">
              <div style="width: 38px; height: 38px; background: #eff6ff; border: 1px solid #bfdbfe; color: #015B91; display: flex; align-items: center; justify-content: center; border-radius: 2px; flex-shrink: 0;">
                <i class="bi bi-telephone-fill fs-5"></i>
              </div>
              <div>
                <strong style="color: #0a1118; font-family: 'Montserrat', sans-serif; text-transform: uppercase; font-size: 0.8rem; display: block;">Mesa Central Telefónica:</strong>
                <a href="tel:<?= APP_PHONE ?>" style="color: #015B91; font-weight: 700; font-family: 'Roboto Mono', monospace; font-size: 0.95rem; text-decoration: none;">
                  <?= APP_PHONE ?>
                </a>
              </div>
            </li>

            <li class="d-flex align-items-start gap-3">
              <div style="width: 38px; height: 38px; background: #eff6ff; border: 1px solid #bfdbfe; color: #015B91; display: flex; align-items: center; justify-content: center; border-radius: 2px; flex-shrink: 0;">
                <i class="bi bi-envelope-fill fs-5"></i>
              </div>
              <div>
                <strong style="color: #0a1118; font-family: 'Montserrat', sans-serif; text-transform: uppercase; font-size: 0.8rem; display: block;">Correo de Contacto:</strong>
                <a href="mailto:<?= APP_EMAIL ?>" style="color: #015B91; font-weight: 600; font-size: 0.88rem; text-decoration: none;">
                  <?= APP_EMAIL ?>
                </a>
              </div>
            </li>

            <li class="d-flex align-items-start gap-3">
              <div style="width: 38px; height: 38px; background: #eff6ff; border: 1px solid #bfdbfe; color: #015B91; display: flex; align-items: center; justify-content: center; border-radius: 2px; flex-shrink: 0;">
                <i class="bi bi-clock-fill fs-5"></i>
              </div>
              <div>
                <strong style="color: #0a1118; font-family: 'Montserrat', sans-serif; text-transform: uppercase; font-size: 0.8rem; display: block;">Horario de Operación:</strong>
                <span style="color: #475569; font-size: 0.85rem;">Lunes a Viernes: 08:30 a 18:30 hrs.<br>Guardia 24/7 para Faenas Mineras</span>
              </div>
            </li>
          </ul>
        </div>

        <!-- TARJETA DE COMPROMISO TÉCNICO -->
        <div style="background: #0a1118; color: #ffffff; border-left: 4px solid #00A3E0; padding: 22px;">
          <h4 style="font-size: 0.95rem; font-family: 'Montserrat', sans-serif; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; color: #38bdf8;">
            <i class="bi bi-patch-check-fill me-1"></i> Compromiso de Calidad VICTORQ
          </h4>
          <p style="font-size: 0.82rem; color: #94a3b8; line-height: 1.5; margin: 0;">
            Todos los requerimientos recibidos son asignados de inmediato a un especialista técnico certificado, garantizando respuesta en menos de 2 horas hábiles.
          </p>
        </div>
      </div>

      <!-- COLUMNA DERECHA: FORMULARIO DE CONTACTO -->
      <div style="background: #ffffff; border: 1px solid #cdd2d6; border-top: 4px solid #015B91; padding: 32px;">
        <h3 style="font-size: 1.15rem; color: #0a1118; margin-bottom: 20px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; text-transform: uppercase;">
          Envíanos tu Requerimiento
        </h3>

        <form action="<?= BASE_URL ?>/contact.php?action=submit" method="POST" id="form-contacto-web">
          <div class="form-2col">
            <div class="form-group-enerpac">
              <label for="name">Nombre y Apellido *</label>
              <input type="text" id="name" name="name" required placeholder="Ej: Ing. Carlos Valenzuela">
            </div>
            <div class="form-group-enerpac">
              <label for="company">Empresa / Razón Social *</label>
              <input type="text" id="company" name="company" required placeholder="Ej: Minera Antucoya / Constructora">
            </div>
          </div>

          <div class="form-2col">
            <div class="form-group-enerpac">
              <label for="rut">RUT Empresa (Opcional)</label>
              <input type="text" id="rut" name="rut" placeholder="76.123.456-7">
            </div>
            <div class="form-group-enerpac">
              <label for="email">Correo Electrónico *</label>
              <input type="email" id="email" name="email" required placeholder="cvalenzuela@empresa.cl">
            </div>
          </div>

          <div class="form-2col">
            <div class="form-group-enerpac">
              <label for="phone">Teléfono de Contacto *</label>
              <input type="text" id="phone" name="phone" required placeholder="+56 9 8765 4321">
            </div>
            <div class="form-group-enerpac">
              <label for="subject">Motivo de Contacto *</label>
              <select id="subject" name="subject" required style="width: 100%; padding: 11px 12px; border: 1px solid #cdd2d6; font-size: 0.85rem; font-family: 'Roboto', sans-serif;">
                <option value="Consulta Comercial y Disponibilidad">Consulta Comercial y Disponibilidad</option>
                <option value="Servicio Técnico y Calibración 700 Bar">Servicio Técnico y Calibración 700 Bar</option>
                <option value="Asesoría Técnica en Terreno / Faena">Asesoría Técnica en Terreno / Faena</option>
                <option value="Postventa y Repuestos Originales">Postventa y Repuestos Originales</option>
                <option value="Otro Requerimiento Industrial">Otro Requerimiento Industrial</option>
              </select>
            </div>
          </div>

          <div class="form-group-enerpac">
            <label for="message">Mensaje / Detalle del Requerimiento *</label>
            <textarea id="message" name="message" rows="4" required placeholder="Describa la aplicación requerida, tonelaje, rango de torque o número de serie del equipo..."></textarea>
          </div>

          <button type="submit" class="btn btn-victorq-primary w-100" id="btn-submit-contact" style="padding: 16px; font-size: 0.95rem; margin-top: 10px;">
            <i class="bi bi-send-fill"></i>
            <span>Enviar Mensaje de Contacto</span>
          </button>
        </form>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const formContact = document.getElementById('form-contacto-web');
    const btnSubmit = document.getElementById('btn-submit-contact');

    if (formContact) {
        formContact.addEventListener('submit', function(e) {
            e.preventDefault();
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando Mensaje...';

            const fd = new FormData(this);

            fetch(BASE_URL + '/contact.php?action=submit', {
                method: 'POST',
                body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="bi bi-send-fill"></i> <span>Enviar Mensaje de Contacto</span>';

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Mensaje Recibido!',
                        text: data.message,
                        confirmButtonColor: '#015B91'
                    });
                    formContact.reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Atención',
                        text: data.message,
                        confirmButtonColor: '#d33'
                    });
                }
            })
            .catch(err => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="bi bi-send-fill"></i> <span>Enviar Mensaje de Contacto</span>';
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Conexión',
                    text: 'Ocurrió un error al enviar el formulario. Por favor intente nuevamente.',
                    confirmButtonColor: '#d33'
                });
            });
        });
    }
});
</script>

</body>
</html>
