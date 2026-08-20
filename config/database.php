<?php
/**
 * Configuración y Conexión de Base de Datos MySQL (PDO Singleton)
 */

class Database {
    private static ?PDO $instance = null;
    
    // Credenciales por defecto para XAMPP
    private static string $host = '127.0.0.1';
    private static string $port = '3306';
    private static string $dbname = 'victorq_catalogo';
    private static string $username = 'root';
    private static string $password = '';
    private static string $charset = 'utf8mb4';

    public static function getConnection(): ?PDO {
        if (self::$instance === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$dbname . ";charset=" . self::$charset;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                ];
                self::$instance = new PDO($dsn, self::$username, self::$password, $options);
            } catch (PDOException $e) {
                // Registrar log de error de conexión
                error_log("Error de conexión a BD MySQL: " . $e->getMessage());
                return null;
            }
        }
        return self::$instance;
    }

    public static function isConnected(): bool {
        return self::getConnection() !== null;
    }

    public static function getCredentials(): array {
        return [
            'host' => self::$host,
            'port' => self::$port,
            'dbname' => self::$dbname,
            'username' => self::$username,
            'password' => self::$password
        ];
    }
}
