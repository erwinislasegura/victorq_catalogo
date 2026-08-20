<?php
/**
 * VICTORQ Industrial - Panel de Control Administrativo
 * Punto de entrada del Backend (MVC Router)
 */

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';

// Si no hay sesión y no se está intentando hacer login, redirigir a login
$module = $_GET['c'] ?? 'dashboard';
$action = $_GET['a'] ?? 'index';

if (!Auth::check() && $module !== 'auth') {
    header('Location: ' . ADMIN_URL . '/?c=auth&a=login');
    exit;
}

// Despachar petición mediante Router
Router::dispatch('DashboardController', 'index');
