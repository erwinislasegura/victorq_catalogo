<?php
/**
 * Instalador Automático de Base de Datos VICTORQ
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$msg = null;
$error = null;
$installed = false;

$host = $_POST['host'] ?? '127.0.0.1';
$port = $_POST['port'] ?? '3306';
$dbname = $_POST['dbname'] ?? 'victorq_catalogo';
$username = $_POST['username'] ?? 'root';
$password = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['install'])) {
    try {
        // Conexión inicial sin seleccionar base de datos para crearla si no existe
        $dsnNoDb = "mysql:host={$host};port={$port};charset=utf8mb4";
        $pdo = new PDO($dsnNoDb, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Crear base de datos si no existe
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `{$dbname}`");

        // 1. Ejecutar Schema
        $schemaFile = __DIR__ . '/schema.sql';
        if (file_exists($schemaFile)) {
            $schemaSql = file_get_contents($schemaFile);
            $pdo->exec($schemaSql);
        } else {
            throw new Exception("No se encontró el archivo schema.sql");
        }

        // 2. Ejecutar Seed
        $seedFile = __DIR__ . '/seed.sql';
        if (file_exists($seedFile)) {
            $seedSql = file_get_contents($seedFile);
            $pdo->exec($seedSql);
        } else {
            throw new Exception("No se encontró el archivo seed.sql");
        }

        // 3. Actualizar config/database.php si las credenciales son diferentes
        $dbConfigFile = dirname(__DIR__) . '/config/database.php';
        if (file_exists($dbConfigFile)) {
            $dbConfigCode = <<<PHP
<?php
/**
 * Configuración y Conexión de Base de Datos MySQL (PDO Singleton)
 */

class Database {
    private static ?PDO \$instance = null;
    
    private static string \$host = '{$host}';
    private static string \$port = '{$port}';
    private static string \$dbname = '{$dbname}';
    private static string \$username = '{$username}';
    private static string \$password = '{$password}';
    private static string \$charset = 'utf8mb4';

    public static function getConnection(): ?PDO {
        if (self::\$instance === null) {
            try {
                \$dsn = "mysql:host=" . self::\$host . ";port=" . self::\$port . ";dbname=" . self::\$dbname . ";charset=" . self::\$charset;
                \$options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                ];
                self::\$instance = new PDO(\$dsn, self::\$username, self::\$password, \$options);
            } catch (PDOException \$e) {
                error_log("Error de conexión a BD MySQL: " . \$e->getMessage());
                return null;
            }
        }
        return self::\$instance;
    }

    public static function isConnected(): bool {
        return self::getConnection() !== null;
    }

    public static function getCredentials(): array {
        return [
            'host' => self::\$host,
            'port' => self::\$port,
            'dbname' => self::\$dbname,
            'username' => self::\$username,
            'password' => self::\$password
        ];
    }
}
PHP;
            file_put_contents($dbConfigFile, $dbConfigCode);
        }

        $msg = "¡Base de datos '{$dbname}' creada e inicializada exitosamente con todos los roles, usuarios, productos, categorías y tablas técnicas!";
        $installed = true;

    } catch (Exception $e) {
        $error = "Error durante la instalación: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalador de Base de Datos — VICTORQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #12161b; color: #e7ebef; font-family: system-ui, -apple-system, sans-serif; }
        .card-install { background: #1b2129; border: 1px solid #2a3441; border-radius: 12px; }
        .text-accent { color: #f5a623; }
        .btn-accent { background: #f5a623; color: #12161b; font-weight: 700; border: none; }
        .btn-accent:hover { background: #ffb84d; color: #12161b; }
    </style>
</head>
<body class="min-vh-100 d-flex align-items-center justify-content-center p-3">
    <div class="card card-install shadow-lg max-w-500 w-100 p-4 p-md-5" style="max-width: 540px;">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-accent mb-1"><i class="bi bi-database-check me-2"></i>VICTORQ INDUSTRIAL</h4>
            <h6 class="text-white fw-bold">Instalador y Semillero de Base de Datos</h6>
            <p class="text-secondary small mb-0">Cree la estructura de tablas y cargue los 24 productos y roles automáticamente.</p>
        </div>

        <?php if ($msg): ?>
            <div class="alert alert-success d-flex align-items-center gap-2 py-3 mb-4">
                <i class="bi bi-check-circle-fill fs-4"></i>
                <div><?= htmlspecialchars($msg) ?></div>
            </div>
            
            <div class="d-grid gap-2 mb-3">
                <a href="../admin/?c=auth&a=login" class="btn btn-accent py-2.5">
                    <i class="bi bi-shield-lock me-1"></i> Ir al Panel de Administración (Login)
                </a>
                <a href="../index.php" class="btn btn-outline-light py-2">
                    <i class="bi bi-globe me-1"></i> Ver Catálogo Público
                </a>
            </div>

            <div class="p-3 bg-dark rounded border border-secondary text-xs mt-3">
                <strong class="text-accent d-block mb-1">Credenciales de Acceso Creadas:</strong>
                <div>Admin: <code>admin@victorq.com</code> / <code>password123</code></div>
                <div>Supervisor: <code>supervisor@victorq.com</code> / <code>password123</code></div>
                <div>Ventas: <code>ventas@victorq.com</code> / <code>password123</code></div>
                <div>Operador: <code>operador@victorq.com</code> / <code>password123</code></div>
            </div>
        <?php else: ?>
            <?php if ($error): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2 py-2 mb-3 small">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div><?= htmlspecialchars($error) ?></div>
                </div>
            <?php endif; ?>

            <form action="install.php" method="POST">
                <div class="row g-2 mb-3">
                    <div class="col-8">
                        <label class="form-label text-xs text-secondary text-uppercase fw-bold">Servidor MySQL (Host)</label>
                        <input type="text" class="form-control form-control-sm bg-dark text-white border-secondary" name="host" value="<?= htmlspecialchars($host) ?>" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-xs text-secondary text-uppercase fw-bold">Puerto</label>
                        <input type="text" class="form-control form-control-sm bg-dark text-white border-secondary" name="port" value="<?= htmlspecialchars($port) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-xs text-secondary text-uppercase fw-bold">Nombre de Base de Datos</label>
                    <input type="text" class="form-control form-control-sm bg-dark text-white border-secondary" name="dbname" value="<?= htmlspecialchars($dbname) ?>" required>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <label class="form-label text-xs text-secondary text-uppercase fw-bold">Usuario MySQL</label>
                        <input type="text" class="form-control form-control-sm bg-dark text-white border-secondary" name="username" value="<?= htmlspecialchars($username) ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label text-xs text-secondary text-uppercase fw-bold">Contraseña MySQL</label>
                        <input type="password" class="form-control form-control-sm bg-dark text-white border-secondary" name="password" value="<?= htmlspecialchars($password) ?>" placeholder="(Vacío en XAMPP)">
                    </div>
                </div>

                <button type="submit" name="install" value="1" class="btn btn-accent w-100 py-2.5 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-cloud-arrow-up-fill fs-5"></i>
                    <span>Crear e Inicializar Base de Datos</span>
                </button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
