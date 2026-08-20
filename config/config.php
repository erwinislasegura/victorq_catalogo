<?php
/**
 * Configuración Global del Sistema VICTORQ
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('America/Santiago');

define('APP_NAME', 'VICTORQ Industrial');
define('APP_VERSION', '2.0.0');
define('APP_COMPANY', 'VICTORQ Torque e Hidráulica');
define('APP_EMAIL', 'info@fieldsindustry.com');
define('APP_PHONE', '+56 9 7140 1455');
define('APP_URL_CATALOG', 'www.vic-torq.com');

define('ROOT_PATH', dirname(__DIR__));
define('CONFIG_PATH', ROOT_PATH . '/config');
define('CORE_PATH', ROOT_PATH . '/core');
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers');
define('MODELS_PATH', ROOT_PATH . '/models');
define('VIEWS_PATH', ROOT_PATH . '/views');
define('ASSETS_PATH', ROOT_PATH . '/assets');

$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
$protocol = $isHttps ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$baseDir = preg_replace('#/(admin|database|views).*$#', '', $scriptDir);
$baseUrl = rtrim($protocol . $host . $baseDir, '/');

define('BASE_URL', $baseUrl);
define('ADMIN_URL', $baseUrl . '/admin');
define('ASSETS_URL', $baseUrl . '/assets');

spl_autoload_register(function ($class) {
    $paths = [
        CORE_PATH . '/' . $class . '.php',
        MODELS_PATH . '/' . $class . '.php',
        CONTROLLERS_PATH . '/' . $class . '.php',
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
