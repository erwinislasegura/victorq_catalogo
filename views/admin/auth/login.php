<?php
$pageTitle = 'Acceso Corporativo';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> — <?= APP_NAME ?></title>
    
    <!-- Google Fonts: Inter & Montserrat for Enerpac Heavy Industrial Feel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="shortcut icon" href="<?= ASSETS_URL ?>/img/logo.png" type="image/png">

    <style>
        :root {
            --enerpac-yellow: #FFD100;
            --enerpac-yellow-hover: #ffdb29;
            --enerpac-yellow-dark: #e5bc00;
            --enerpac-dark: #12161b;
            --enerpac-navy: #013a5e;
            --enerpac-blue: #015b91;
            --enerpac-light-blue: #3a8bc2;
            --enerpac-gray-bg: #f4f5f7;
            --enerpac-card-border: #e2e8f0;
            --enerpac-text-dark: #0f172a;
            --enerpac-text-muted: #64748b;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #0b0f14;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(1, 91, 145, 0.25) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(255, 209, 0, 0.1) 0%, transparent 40%),
                linear-gradient(135deg, #090d12 0%, #121820 50%, #0d131a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 24px;
            color: #ffffff;
        }

        /* Top Yellow Industrial Accent Bar */
        .top-stripe {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--enerpac-yellow) 0%, #ffae00 100%);
            z-index: 9999;
        }

        /* Main Container Card */
        .enerpac-login-container {
            max-width: 980px;
            width: 100%;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7), 0 0 30px rgba(1, 91, 145, 0.2);
            overflow: hidden;
            display: flex;
            flex-direction: row;
        }

        /* Left Side: Industrial Power Banner */
        .enerpac-banner-side {
            flex: 1 1 45%;
            background: 
                linear-gradient(135deg, rgba(1, 58, 94, 0.95) 0%, rgba(18, 22, 27, 0.98) 100%),
                repeating-linear-gradient(45deg, #131b24 0 2px, #0f151c 2px 20px);
            padding: 44px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .enerpac-banner-side::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--enerpac-yellow);
        }

        .banner-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .banner-brand-logo {
            background: #ffffff;
            padding: 6px 14px;
            border-radius: 6px;
            display: inline-flex;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .banner-brand-logo img {
            height: 32px;
            object-fit: contain;
        }

        .banner-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.65rem;
            font-weight: 900;
            line-height: 1.15;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-top: 24px;
        }

        .banner-title span {
            color: var(--enerpac-yellow);
            display: block;
        }

        .banner-desc {
            color: #cbd5e1;
            font-size: 0.88rem;
            line-height: 1.55;
            margin-top: 14px;
        }

        .banner-features {
            list-style: none;
            padding: 0;
            margin: 24px 0 0 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .banner-features li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.82rem;
            color: #e2e8f0;
            font-weight: 500;
        }

        .banner-features li i {
            color: var(--enerpac-yellow);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .banner-stats-bar {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            padding-top: 20px;
            margin-top: 30px;
        }

        .stat-item strong {
            display: block;
            font-size: 1.25rem;
            color: var(--enerpac-yellow);
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
        }

        .stat-item span {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
        }

        /* Right Side: Clean High-Contrast Form */
        .enerpac-form-side {
            flex: 1 1 55%;
            background: #ffffff;
            padding: 44px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: var(--enerpac-text-dark);
        }

        .form-heading {
            margin-bottom: 24px;
        }

        .form-heading-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(1, 91, 145, 0.08);
            color: var(--enerpac-blue);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 4px 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .form-heading h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 6px 0;
            letter-spacing: -0.3px;
        }

        .form-heading p {
            color: var(--enerpac-text-muted);
            font-size: 0.84rem;
            margin: 0;
        }

        /* Form Inputs (Enerpac Clean Rugged Style) */
        .form-group-enerpac {
            margin-bottom: 18px;
        }

        .form-label-enerpac {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #334155;
            margin-bottom: 6px;
            display: block;
        }

        .input-wrapper-enerpac {
            position: relative;
            display: flex;
            align-items: center;
            border: 2px solid #cbd5e1;
            border-radius: 6px;
            background: #f8fafc;
            transition: all 0.2s ease;
        }

        .input-wrapper-enerpac:focus-within {
            border-color: #015b91;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(1, 91, 145, 0.15);
        }

        .input-icon-enerpac {
            padding: 0 14px;
            color: #64748b;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
        }

        .input-wrapper-enerpac:focus-within .input-icon-enerpac {
            color: #015b91;
        }

        .input-field-enerpac {
            width: 100%;
            border: none;
            background: transparent;
            padding: 11px 12px 11px 0;
            font-size: 0.92rem;
            font-weight: 500;
            color: #0f172a;
            outline: none;
        }

        .input-field-enerpac::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .btn-toggle-pw {
            background: none;
            border: none;
            color: #64748b;
            padding: 0 14px;
            cursor: pointer;
            font-size: 1.05rem;
            transition: color 0.2s;
        }

        .btn-toggle-pw:hover {
            color: #0f172a;
        }

        /* Enerpac High-Impact Action Button */
        .btn-enerpac-submit {
            background: var(--enerpac-yellow);
            color: #000000;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 14px 24px;
            border-radius: 6px;
            border: 2px solid #e5bc00;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(255, 209, 0, 0.35);
            transition: all 0.2s ease;
            margin-top: 6px;
        }

        .btn-enerpac-submit:hover {
            background: var(--enerpac-yellow-hover);
            border-color: var(--enerpac-yellow);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(255, 209, 0, 0.45);
        }

        .btn-enerpac-submit:active {
            transform: translateY(0);
        }

        /* Demo Quick Access Grid */
        .demo-roles-container {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid #e2e8f0;
        }

        .demo-roles-header {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .demo-roles-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .demo-role-btn {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            text-align: left;
            transition: all 0.15s ease;
        }

        .demo-role-btn:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }

        .demo-role-btn.active-role {
            background: #fffbeb;
            border-color: var(--enerpac-yellow-dark);
            box-shadow: 0 0 0 1px var(--enerpac-yellow);
        }

        .demo-badge-icon {
            width: 26px;
            height: 26px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .badge-admin { background: #e0f2fe; color: #0284c7; }
        .badge-super { background: #f3e8ff; color: #9333ea; }
        .badge-sales { background: #fef3c7; color: #d97706; }
        .badge-oper  { background: #dcfce7; color: #16a34a; }

        .demo-text-main {
            font-size: 0.78rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.2;
        }

        .demo-text-sub {
            font-size: 0.68rem;
            color: #64748b;
        }

        /* Back to catalog link */
        .link-back-catalog {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            margin-top: 18px;
            transition: color 0.2s;
        }

        .link-back-catalog:hover {
            color: #015b91;
            text-decoration: underline;
        }

        /* Alerts */
        .alert-enerpac {
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 0.82rem;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-enerpac-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }
        .alert-enerpac-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
        }

        /* Responsive layout */
        @media (max-width: 820px) {
            .enerpac-login-container {
                flex-direction: column;
            }
            .enerpac-banner-side {
                padding: 30px 24px;
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
            .enerpac-form-side {
                padding: 30px 24px;
            }
            .banner-stats-bar {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="top-stripe"></div>

<div class="enerpac-login-container">
    <!-- LEFT COLUMN: Industrial Power Branding (Enerpac Inspired) -->
    <div class="enerpac-banner-side">
        <div>
            <div class="banner-brand">
                <div class="banner-brand-logo">
                    <img src="<?= ASSETS_URL ?>/img/logo.png" alt="<?= APP_NAME ?>">
                </div>
            </div>

            <div class="banner-title">
                POTENCIA HIDRÁULICA
                <span>Y TORQUE DE 700 BAR</span>
            </div>

            <p class="banner-desc">
                Portal corporativo de gestión de equipos industriales, fichas de ingeniería y control de cotizaciones en tiempo real.
            </p>

            <ul class="banner-features">
                <li>
                    <i class="bi bi-shield-check"></i>
                    <span>Control de acceso por roles y permisos RBAC</span>
                </li>
                <li>
                    <i class="bi bi-speedometer2"></i>
                    <span>Catálogo de llaves, bombas, cilindros y bridas</span>
                </li>
                <li>
                    <i class="bi bi-file-earmark-spreadsheet"></i>
                    <span>Tablas de torque y capacidad técnica integradas</span>
                </li>
                <li>
                    <i class="bi bi-headset"></i>
                    <span>Gestión y trazabilidad de cotizaciones industriales</span>
                </li>
            </ul>
        </div>

        <div class="banner-stats-bar">
            <div class="stat-item">
                <strong>700 BAR</strong>
                <span>Presión Máx.</span>
            </div>
            <div class="stat-item">
                <strong>37.000</strong>
                <span>Lb-pie Torque</span>
            </div>
            <div class="stat-item">
                <strong>1.000 TON</strong>
                <span>Levante Pesado</span>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Sign In Form -->
    <div class="enerpac-form-side">
        <div class="form-heading">
            <div class="form-heading-badge">
                <i class="bi bi-lock-fill"></i> Acceso Seguro
            </div>
            <h2>INICIAR SESIÓN</h2>
            <p>Ingrese sus credenciales corporativas para continuar.</p>
        </div>

        <!-- Flash Messages -->
        <?php if (!empty($flashError)): ?>
            <div class="alert-enerpac alert-enerpac-danger">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                <div><?= htmlspecialchars($flashError) ?></div>
            </div>
        <?php endif; ?>
        <?php if (!empty($flashSuccess)): ?>
            <div class="alert-enerpac alert-enerpac-success">
                <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                <div><?= htmlspecialchars($flashSuccess) ?></div>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="<?= ADMIN_URL ?>/?c=auth&a=login" method="POST" id="enerpacLoginForm">
            <!-- Email -->
            <div class="form-group-enerpac">
                <label for="email" class="form-label-enerpac">Correo Electrónico Corporativo</label>
                <div class="input-wrapper-enerpac">
                    <div class="input-icon-enerpac"><i class="bi bi-envelope"></i></div>
                    <input type="email" class="input-field-enerpac" id="email" name="email" 
                           value="<?= htmlspecialchars($email ?? 'admin@victorq.com') ?>" 
                           required autofocus placeholder="usuario@victorq.com">
                </div>
            </div>

            <!-- Password -->
            <div class="form-group-enerpac mb-3">
                <label for="password" class="form-label-enerpac">Contraseña</label>
                <div class="input-wrapper-enerpac">
                    <div class="input-icon-enerpac"><i class="bi bi-shield-lock"></i></div>
                    <input type="password" class="input-field-enerpac" id="password" name="password" 
                           value="password123" required placeholder="••••••••">
                    <button type="button" class="btn-toggle-pw" id="btnTogglePw" title="Mostrar/Ocultar contraseña">
                        <i class="bi bi-eye" id="pwIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-enerpac-submit" id="btnSubmit">
                <span>INGRESAR AL PANEL</span>
                <i class="bi bi-arrow-right-circle-fill fs-5"></i>
            </button>
        </form>

        <!-- Quick Demo Role Selectors -->
        <div class="demo-roles-container">
            <div class="demo-roles-header">
                <span><i class="bi bi-person-badge me-1"></i> Perfiles Demo (Clave: <code>password123</code>)</span>
            </div>
            <div class="demo-roles-grid">
                <!-- Admin -->
                <button type="button" class="demo-role-btn active-role" data-email="admin@victorq.com">
                    <div class="demo-badge-icon badge-admin"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <div class="demo-text-main">Administrador</div>
                        <div class="demo-text-sub">Acceso Total</div>
                    </div>
                </button>

                <!-- Supervisor -->
                <button type="button" class="demo-role-btn" data-email="supervisor@victorq.com">
                    <div class="demo-badge-icon badge-super"><i class="bi bi-person-workspace"></i></div>
                    <div>
                        <div class="demo-text-main">Supervisor</div>
                        <div class="demo-text-sub">Catálogo & Tablas</div>
                    </div>
                </button>

                <!-- Ventas -->
                <button type="button" class="demo-role-btn" data-email="ventas@victorq.com">
                    <div class="demo-badge-icon badge-sales"><i class="bi bi-briefcase"></i></div>
                    <div>
                        <div class="demo-text-main">Ventas</div>
                        <div class="demo-text-sub">Cotizaciones</div>
                    </div>
                </button>

                <!-- Operador -->
                <button type="button" class="demo-role-btn" data-email="operador@victorq.com">
                    <div class="demo-badge-icon badge-oper"><i class="bi bi-eye"></i></div>
                    <div>
                        <div class="demo-text-main">Operador</div>
                        <div class="demo-text-sub">Solo Consulta</div>
                    </div>
                </button>
            </div>
        </div>

        <!-- Back to Catalog -->
        <div class="d-flex justify-content-between align-items-center mt-3 pt-2">
            <a href="<?= BASE_URL ?>/index.php" class="link-back-catalog">
                <i class="bi bi-arrow-left"></i> Volver al Catálogo Web
            </a>
            <small class="text-muted text-xs">&copy; <?= date('Y') ?> VICTORQ</small>
        </div>
    </div>
</div>

<script>
// Toggle Password
const btnTogglePw = document.getElementById('btnTogglePw');
const inputPw = document.getElementById('password');
const pwIcon = document.getElementById('pwIcon');

if (btnTogglePw && inputPw) {
    btnTogglePw.addEventListener('click', function() {
        const isPassword = inputPw.getAttribute('type') === 'password';
        inputPw.setAttribute('type', isPassword ? 'text' : 'password');
        pwIcon.classList.toggle('bi-eye', !isPassword);
        pwIcon.classList.toggle('bi-eye-slash', isPassword);
    });
}

// Demo Roles Selector
const demoBtns = document.querySelectorAll('.demo-role-btn');
const inputEmail = document.getElementById('email');

demoBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        demoBtns.forEach(b => b.classList.remove('active-role'));
        this.classList.add('active-role');

        inputEmail.value = this.dataset.email;
        inputPw.value = 'password123';

        // Visual feedback
        const wrapper = inputEmail.closest('.input-wrapper-enerpac');
        wrapper.style.borderColor = '#FFD100';
        setTimeout(() => {
            wrapper.style.borderColor = '';
        }, 400);
    });
});
</script>

</body>
</html>
