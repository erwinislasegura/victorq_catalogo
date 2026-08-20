<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Página no encontrada | <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/admin.css">
</head>
<body class="bg-corporate-dark min-vh-100 d-flex align-items-center justify-content-center p-3">
    <div class="card shadow-lg border-0 rounded-4 p-5 text-center bg-corporate-card text-white max-w-500 w-100">
        <img src="<?= ASSETS_URL ?>/img/logo.png" alt="<?= APP_NAME ?>" height="38" class="mx-auto mb-3">
        <h1 class="display-4 fw-bold text-warning mb-2">404</h1>
        <h5 class="fw-bold mb-2">Página o Módulo No Encontrado</h5>
        <p class="text-white-50 text-xs mb-4">El enlace al que intenta acceder no existe o fue reubicado.</p>
        <div class="d-flex justify-content-center gap-2">
            <a href="<?= ADMIN_URL ?>/?c=dashboard" class="btn btn-warning btn-sm text-dark fw-bold px-3">
                <i class="bi bi-speedometer2 me-1"></i> Ir al Panel
            </a>
            <a href="<?= BASE_URL ?>/index.php" class="btn btn-outline-light btn-sm px-3">
                <i class="bi bi-globe me-1"></i> Ir al Catálogo
            </a>
        </div>
    </div>
</body>
</html>
