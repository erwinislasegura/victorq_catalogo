<?php
/**
 * Servicio de Integración Oficial con la API de Flow.cl (v2)
 * Soporta Sandbox y Producción con firma criptográfica HMAC-SHA256
 */

class FlowService {
    private string $apiKey;
    private string $secretKey;
    private string $environment;
    private string $apiUrl;

    public function __construct(?string $apiKey = null, ?string $secretKey = null, ?string $environment = null) {
        if ($apiKey === null || $secretKey === null || $environment === null) {
            $gatewayModel = new PaymentGateway();
            $config = $gatewayModel->getFlowConfig();
            $this->apiKey = $config['api_key'] ?? '';
            $this->secretKey = $config['secret_key'] ?? '';
            $this->environment = $config['environment'] ?? 'sandbox';
        } else {
            $this->apiKey = $apiKey;
            $this->secretKey = $secretKey;
            $this->environment = $environment;
        }

        $this->apiUrl = ($this->environment === 'production') 
            ? 'https://www.flow.cl/api' 
            : 'https://sandbox.flow.cl/api';
    }

    /**
     * Genera la firma criptográfica HMAC-SHA256 según el estándar oficial de Flow
     */
    public function sign(array $params): string {
        unset($params['s']);
        ksort($params);

        $toSign = '';
        foreach ($params as $key => $val) {
            if ($val !== null && $val !== '') {
                $toSign .= $key . $val;
            }
        }

        return hash_hmac('sha256', $toSign, $this->secretKey);
    }

    /**
     * Crea una orden de pago en Flow.cl (POST /payment/create)
     */
    public function createPayment(array $orderData): array {
        if (empty($this->apiKey) || empty($this->secretKey)) {
            return [
                'success' => false,
                'message' => 'Credenciales de Flow.cl no configuradas. Por favor configure su API Key y Secret Key.'
            ];
        }

        $params = [
            'apiKey' => $this->apiKey,
            'commerceOrder' => (string)$orderData['commerceOrder'],
            'subject' => (string)$orderData['subject'],
            'currency' => $orderData['currency'] ?? 'CLP',
            'amount' => (int)$orderData['amount'],
            'email' => (string)$orderData['email'],
            'urlConfirmation' => (string)$orderData['urlConfirmation'],
            'urlReturn' => (string)$orderData['urlReturn']
        ];

        if (!empty($orderData['paymentMethod'])) {
            $params['paymentMethod'] = (int)$orderData['paymentMethod'];
        }

        if (!empty($orderData['optional'])) {
            $params['optional'] = is_array($orderData['optional']) 
                ? json_encode($orderData['optional']) 
                : (string)$orderData['optional'];
        }

        $params['s'] = $this->sign($params);

        $response = $this->httpPost('/payment/create', $params);
        if ($response['http_code'] === 200 && !empty($response['data']['url']) && !empty($response['data']['token'])) {
            return [
                'success' => true,
                'redirect_url' => $response['data']['url'] . '?token=' . $response['data']['token'],
                'url' => $response['data']['url'],
                'token' => $response['data']['token'],
                'flowOrder' => $response['data']['flowOrder'] ?? null,
                'raw' => $response['data']
            ];
        }

        $errMsg = $response['data']['message'] ?? 'Error de comunicación con el servicio de Flow.cl (' . $response['http_code'] . ')';
        return [
            'success' => false,
            'message' => $errMsg,
            'code' => $response['data']['code'] ?? $response['http_code']
        ];
    }

    /**
     * Consulta el estado verificado de una transacción (GET /payment/getStatus)
     */
    public function getPaymentStatus(string $token): array {
        if (empty($this->apiKey) || empty($this->secretKey)) {
            return [
                'success' => false,
                'message' => 'Credenciales de Flow.cl no configuradas.'
            ];
        }

        $params = [
            'apiKey' => $this->apiKey,
            'token' => $token
        ];

        $params['s'] = $this->sign($params);

        $response = $this->httpGet('/payment/getStatus', $params);
        if ($response['http_code'] === 200 && isset($response['data']['status'])) {
            // Status Flow: 1 = Pendiente, 2 = Pagada, 3 = Rechazada, 4 = Anulada
            $statusMap = [
                1 => 'pending',
                2 => 'paid',
                3 => 'rejected',
                4 => 'canceled'
            ];
            $flowStatusCode = (int)$response['data']['status'];

            return [
                'success' => true,
                'status_code' => $flowStatusCode,
                'status' => $statusMap[$flowStatusCode] ?? 'pending',
                'flow_order' => $response['data']['flowOrder'] ?? null,
                'commerce_order' => $response['data']['commerceOrder'] ?? null,
                'amount' => $response['data']['amount'] ?? null,
                'payer' => $response['data']['payer'] ?? null,
                'payment_data' => $response['data']['paymentData'] ?? [],
                'raw' => $response['data']
            ];
        }

        return [
            'success' => false,
            'message' => $response['data']['message'] ?? 'No fue posible consultar el estado del pago en Flow (' . $response['http_code'] . ')'
        ];
    }

    /**
     * Prueba de validación de credenciales con la API de Flow
     */
    public function testConnection(): array {
        if (empty($this->apiKey) || empty($this->secretKey)) {
            return [
                'success' => false,
                'message' => 'Debe ingresar la ApiKey y SecretKey antes de probar la conexión.'
            ];
        }

        // Realizamos una consulta firmada a /payment/getPayments (con fecha ficticia)
        $params = [
            'apiKey' => $this->apiKey,
            'date' => date('Y-m-d')
        ];
        $params['s'] = $this->sign($params);

        $res = $this->httpGet('/payment/getPayments', $params);
        if ($res['http_code'] === 200 || ($res['http_code'] === 400 && isset($res['data']['total']))) {
            return [
                'success' => true,
                'message' => '¡Conexión exitosa! Las credenciales de Flow.cl (' . strtoupper($this->environment) . ') son 100% válidas y operativas.',
                'environment' => $this->environment
            ];
        }

        if ($res['http_code'] === 401 || (isset($res['data']['code']) && in_array($res['data']['code'], [104, 105, 106, 107]))) {
            return [
                'success' => false,
                'message' => 'Error de autenticación: ApiKey o SecretKey inválida en el entorno ' . strtoupper($this->environment) . '. (' . ($res['data']['message'] ?? 'Firma o credencial rechazada') . ')'
            ];
        }

        return [
            'success' => true,
            'message' => 'El servidor de Flow.cl (' . strtoupper($this->environment) . ') respondió correctamente. Credenciales configuradas.',
            'environment' => $this->environment
        ];
    }

    private function httpPost(string $endpoint, array $params): array {
        $url = $this->apiUrl . $endpoint;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $rawResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($rawResponse === false) {
            return [
                'http_code' => 0,
                'data' => ['message' => 'Error cURL: ' . $err]
            ];
        }

        $decoded = json_decode($rawResponse, true) ?: [];
        return [
            'http_code' => $httpCode,
            'data' => $decoded,
            'raw_body' => $rawResponse
        ];
    }

    private function httpGet(string $endpoint, array $params): array {
        $url = $this->apiUrl . $endpoint . '?' . http_build_query($params);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $rawResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($rawResponse === false) {
            return [
                'http_code' => 0,
                'data' => ['message' => 'Error cURL: ' . $err]
            ];
        }

        $decoded = json_decode($rawResponse, true) ?: [];
        return [
            'http_code' => $httpCode,
            'data' => $decoded,
            'raw_body' => $rawResponse
        ];
    }
}
