<?php
/**
 * Modelo de Pasarelas de Pago (Flow.cl, etc.)
 */

class PaymentGateway extends Model {
    protected string $table = 'payment_gateways';

    public function __construct() {
        parent::__construct();
        if ($this->db) {
            $this->checkSchema();
        }
    }

    private function checkSchema(): void {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS `payment_gateways` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `code` VARCHAR(50) NOT NULL UNIQUE,
                `name` VARCHAR(100) NOT NULL,
                `api_key` VARCHAR(255) NULL,
                `secret_key` VARCHAR(255) NULL,
                `environment` ENUM('sandbox', 'production') DEFAULT 'sandbox',
                `currency` VARCHAR(10) DEFAULT 'CLP',
                `is_active` TINYINT(1) DEFAULT 0,
                `settings_json` TEXT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $this->db->exec($sql);

            // Asegurar que exista la fila por defecto para Flow.cl
            $existing = $this->findByCode('flow');
            if (!$existing) {
                $insert = "INSERT INTO `payment_gateways` (`code`, `name`, `api_key`, `secret_key`, `environment`, `currency`, `is_active`) 
                           VALUES ('flow', 'Flow.cl Pagos (Webpay, Servipag, Mach)', '', '', 'sandbox', 'CLP', 0)";
                $this->db->exec($insert);
            }
        } catch (Exception $e) {
            // Silencioso en caso de inicialización previa
        }
    }

    public function findByCode(string $code): ?array {
        if (!$this->db) return null;
        $rows = $this->where('code = :code LIMIT 1', ['code' => $code]);
        return $rows[0] ?? null;
    }

    public function getFlowConfig(): array {
        $gw = $this->findByCode('flow');
        if (!$gw) {
            return [
                'code' => 'flow',
                'name' => 'Flow.cl',
                'api_key' => '',
                'secret_key' => '',
                'environment' => 'sandbox',
                'currency' => 'CLP',
                'is_active' => 0
            ];
        }
        return $gw;
    }
}
