<?php
/**
 * Vista de Configuración de Pasarela Flow.cl (Admin)
 */
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="mb-1 fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-credit-card-2-front-fill text-primary"></i>
            <span>Configuración de Pasarela Flow.cl</span>
        </h4>
        <p class="text-muted text-xs mb-0">Gestión de credenciales API, entorno (Sandbox / Producción) y webhooks para pagos con Webpay, Servipag y tarjetas.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= ADMIN_URL ?>/?c=payment_config&a=orders" class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1.5 text-xs">
            <i class="bi bi-receipt"></i>
            <span>Ver Órdenes y Transacciones</span>
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Formulario de Configuración Principal -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3 bg-white">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-sliders2 text-primary"></i>
                    <span>Parámetros de Integración API Flow</span>
                </h6>
                <span class="badge <?= ($config['environment'] ?? '') === 'production' ? 'bg-success' : 'bg-warning text-dark' ?> text-xxs px-2 py-1 text-uppercase fw-bold">
                    Entorno: <?= strtoupper($config['environment'] ?? 'sandbox') ?>
                </span>
            </div>

            <div class="card-body p-4">
                <form action="<?= ADMIN_URL ?>/?c=payment_config" method="POST" id="form-flow-config">
                    <div class="row g-3">
                        <!-- Switch Activar Pasarela -->
                        <div class="col-12">
                            <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="fw-bold text-dark text-sm">Habilitar Pasarela de Pagos Flow.cl</div>
                                    <div class="text-muted text-xxs">Al activar, los clientes podrán pagar directamente con Webpay, Servipag y Mach en el checkout.</div>
                                </div>
                                <div class="form-check form-switch fs-5 mb-0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= (!empty($config['is_active'])) ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div>

                        <!-- Selector de Entorno -->
                        <div class="col-md-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Entorno de Operación *</label>
                            <select class="form-select form-select-sm" name="environment" id="environment" required>
                                <option value="sandbox" <?= (($config['environment'] ?? '') === 'sandbox') ? 'selected' : '' ?>>Sandbox (Pruebas - sandbox.flow.cl)</option>
                                <option value="production" <?= (($config['environment'] ?? '') === 'production') ? 'selected' : '' ?>>Producción (Real - www.flow.cl)</option>
                            </select>
                            <small class="text-muted text-xxs">Utilice Sandbox para realizar pagos de prueba sin cargos reales.</small>
                        </div>

                        <!-- Moneda -->
                        <div class="col-md-6">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Moneda por Defecto *</label>
                            <select class="form-select form-select-sm" name="currency" id="currency" required>
                                <option value="CLP" <?= (($config['currency'] ?? 'CLP') === 'CLP') ? 'selected' : '' ?>>CLP - Pesos Chilenos</option>
                                <option value="USD" <?= (($config['currency'] ?? '') === 'USD') ? 'selected' : '' ?>>USD - Dólares Americanos</option>
                            </select>
                        </div>

                        <!-- ApiKey -->
                        <div class="col-12">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">API Key (ApiKey) *</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-key-fill"></i></span>
                                <input type="text" class="form-control font-monospace" id="api_key" name="api_key" value="<?= htmlspecialchars($config['api_key'] ?? '') ?>" placeholder="Ej: 3A9184B2-XXXX-XXXX-XXXX-XXXXXXXXXXXX" required>
                            </div>
                            <small class="text-muted text-xxs">Obtenga su ApiKey desde su cuenta Flow en <strong>Mis Datos > Integración</strong>.</small>
                        </div>

                        <!-- SecretKey -->
                        <div class="col-12">
                            <label class="form-label text-xs fw-semibold text-muted text-uppercase">Secret Key (Llave Secreta HMAC) *</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-shield-lock-fill"></i></span>
                                <input type="password" class="form-control font-monospace" id="secret_key" name="secret_key" value="<?= htmlspecialchars($config['secret_key'] ?? '') ?>" placeholder="Ej: a94f81c9b2e04f..." required>
                                <button class="btn btn-outline-secondary" type="button" id="btn-toggle-secret" title="Mostrar/Ocultar"><i class="bi bi-eye"></i></button>
                            </div>
                            <small class="text-muted text-xxs">Utilizada para firmar todas las peticiones con algoritmo HMAC-SHA256.</small>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="col-12 d-flex align-items-center justify-content-between pt-3 border-top mt-4">
                            <button type="button" class="btn btn-sm btn-outline-info d-flex align-items-center gap-1.5 text-xs fw-bold" id="btn-test-connection">
                                <i class="bi bi-arrow-repeat"></i>
                                <span>Probar Conexión con Flow</span>
                            </button>

                            <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center gap-1.5 text-xs fw-bold px-4">
                                <i class="bi bi-save"></i>
                                <span>Guardar Configuración</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- URLs de Retorno y Webhooks de Flow -->
    <div class="col-lg-4">
        <!-- Tarjeta de URLs de Notificación -->
        <div class="card shadow-sm border-0 rounded-3 bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-link-45deg text-success fs-5"></i>
                    <span>URLs de Notificación y Retorno</span>
                </h6>
            </div>
            <div class="card-body p-3">
                <p class="text-muted text-xxs mb-3">Estas URLs son enviadas dinámicamente en cada transacción hacia Flow para redirigir al pagador y recibir la confirmación asíncrona:</p>

                <!-- URL Retorno -->
                <div class="mb-3">
                    <label class="form-label text-xxs fw-bold text-uppercase text-muted mb-1">URL de Retorno (urlReturn):</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control text-xxs font-monospace bg-light" value="<?= htmlspecialchars($urlReturn) ?>" readonly id="url-return-input">
                        <button class="btn btn-outline-secondary btn-copy" type="button" data-target="url-return-input" title="Copiar"><i class="bi bi-clipboard"></i></button>
                    </div>
                </div>

                <!-- URL Confirmación / Webhook -->
                <div class="mb-2">
                    <label class="form-label text-xxs fw-bold text-uppercase text-muted mb-1">URL de Confirmación (urlConfirmation):</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control text-xxs font-monospace bg-light" value="<?= htmlspecialchars($urlConfirmation) ?>" readonly id="url-webhook-input">
                        <button class="btn btn-outline-secondary btn-copy" type="button" data-target="url-webhook-input" title="Copiar"><i class="bi bi-clipboard"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Información de Medios de Pago -->
        <div class="card shadow-sm border-0 rounded-3 bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-shield-check text-primary fs-5"></i>
                    <span>Medios de Pago Habilitados</span>
                </h6>
            </div>
            <div class="card-body p-3">
                <ul class="list-unstyled text-xs text-muted mb-0 d-flex flex-column gap-2">
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span><strong>Webpay Plus:</strong> Débito (Redcompra) y Crédito (Visa, Mastercard, AMEX).</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span><strong>Servipag:</strong> Pago bancario en línea.</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span><strong>Mach / Onepay / Fpay:</strong> Billeteras digitales móviles.</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span><strong>Transferencia Electrónica:</strong> Khipu y comprobante bancario.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle visibilidad SecretKey
    const btnToggle = document.getElementById('btn-toggle-secret');
    const secretInput = document.getElementById('secret_key');
    if (btnToggle && secretInput) {
        btnToggle.addEventListener('click', function() {
            if (secretInput.type === 'password') {
                secretInput.type = 'text';
                btnToggle.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                secretInput.type = 'password';
                btnToggle.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
    }

    // Copiar URLs
    document.querySelectorAll('.btn-copy').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            if (targetInput) {
                targetInput.select();
                navigator.clipboard.writeText(targetInput.value);
                
                const origHtml = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check2 text-success"></i>';
                setTimeout(() => { this.innerHTML = origHtml; }, 2000);
            }
        });
    });

    // Probar Conexión con Flow
    const btnTest = document.getElementById('btn-test-connection');
    if (btnTest) {
        btnTest.addEventListener('click', function() {
            const apiKey = document.getElementById('api_key').value.trim();
            const secretKey = document.getElementById('secret_key').value.trim();
            const environment = document.getElementById('environment').value;

            if (!apiKey || !secretKey) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos requeridos',
                    text: 'Debe ingresar la ApiKey y SecretKey antes de realizar el test.',
                    confirmButtonColor: '#015B91'
                });
                return;
            }

            btnTest.disabled = true;
            btnTest.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Probando...';

            const formData = new FormData();
            formData.append('api_key', apiKey);
            formData.append('secret_key', secretKey);
            formData.append('environment', environment);

            fetch('<?= ADMIN_URL ?>/?c=payment_config&a=test', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btnTest.disabled = false;
                btnTest.innerHTML = '<i class="bi bi-arrow-repeat"></i> <span>Probar Conexión con Flow</span>';

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Conexión Exitosa!',
                        text: data.message,
                        confirmButtonColor: '#015B91'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Conexión',
                        text: data.message,
                        confirmButtonColor: '#d33'
                    });
                }
            })
            .catch(err => {
                btnTest.disabled = false;
                btnTest.innerHTML = '<i class="bi bi-arrow-repeat"></i> <span>Probar Conexión con Flow</span>';
                Swal.fire({
                    icon: 'error',
                    title: 'Error en la petición',
                    text: 'No fue posible contactar con el endpoint de test.',
                    confirmButtonColor: '#d33'
                });
            });
        });
    }
});
</script>
