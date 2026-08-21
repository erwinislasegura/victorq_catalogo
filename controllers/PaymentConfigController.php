<?php
/**
 * Controlador de Configuración de Pasarela de Pagos (Flow.cl) y Transacciones
 */

class PaymentConfigController extends Controller {

    public function index(): void {
        Auth::requirePermission('payment_gateways', 'view');

        $gatewayModel = new PaymentGateway();
        $flowConfig = $gatewayModel->getFlowConfig();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requirePermission('payment_gateways', 'edit');

            $apiKey = trim($_POST['api_key'] ?? '');
            $secretKey = trim($_POST['secret_key'] ?? '');
            $environment = in_array($_POST['environment'] ?? '', ['sandbox', 'production']) ? $_POST['environment'] : 'sandbox';
            $currency = trim($_POST['currency'] ?? 'CLP');
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            $gateway = $gatewayModel->findByCode('flow');
            if ($gateway) {
                $gatewayModel->update($gateway['id'], [
                    'api_key' => $apiKey,
                    'secret_key' => $secretKey,
                    'environment' => $environment,
                    'currency' => $currency,
                    'is_active' => $isActive
                ]);
            } else {
                $gatewayModel->create([
                    'code' => 'flow',
                    'name' => 'Flow.cl Pagos (Webpay, Servipag, Mach)',
                    'api_key' => $apiKey,
                    'secret_key' => $secretKey,
                    'environment' => $environment,
                    'currency' => $currency,
                    'is_active' => $isActive
                ]);
            }

            $this->setFlash('success', 'Configuración de la pasarela Flow.cl guardada exitosamente.');
            $this->redirect(ADMIN_URL . '/?c=payment_config');
        }

        $urlReturn = BASE_URL . '/payment_return.php';
        $urlConfirmation = BASE_URL . '/payment_webhook.php';

        $this->render('admin/payments/config', [
            'config' => $flowConfig,
            'urlReturn' => $urlReturn,
            'urlConfirmation' => $urlConfirmation
        ]);
    }

    public function test(): void {
        header('Content-Type: application/json; charset=utf-8');
        Auth::requirePermission('payment_gateways', 'view');

        $apiKey = trim($_POST['api_key'] ?? '');
        $secretKey = trim($_POST['secret_key'] ?? '');
        $environment = trim($_POST['environment'] ?? 'sandbox');

        if (empty($apiKey) || empty($secretKey)) {
            $gatewayModel = new PaymentGateway();
            $stored = $gatewayModel->getFlowConfig();
            $apiKey = !empty($apiKey) ? $apiKey : $stored['api_key'];
            $secretKey = !empty($secretKey) ? $secretKey : $stored['secret_key'];
            $environment = !empty($environment) ? $environment : $stored['environment'];
        }

        if (empty($apiKey) || empty($secretKey)) {
            echo json_encode([
                'success' => false,
                'message' => 'Por favor ingrese la ApiKey y SecretKey para realizar la prueba.'
            ]);
            exit;
        }

        $flowService = new FlowService($apiKey, $secretKey, $environment);
        $result = $flowService->testConnection();

        echo json_encode($result);
        exit;
    }

    public function orders(): void {
        Auth::requirePermission('payment_gateways', 'view');

        $orderModel = new PaymentOrder();
        $statusFilter = $_GET['status'] ?? 'all';
        $orders = $orderModel->getAllOrders($statusFilter);

        $this->render('admin/payments/orders', [
            'orders' => $orders,
            'selectedStatus' => $statusFilter
        ]);
    }

    public function viewOrder(): void {
        header('Content-Type: application/json; charset=utf-8');
        Auth::requirePermission('payment_gateways', 'view');

        $id = (int)($_GET['id'] ?? 0);
        $orderModel = new PaymentOrder();
        $order = $orderModel->find($id);

        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Orden no encontrada']);
            exit;
        }

        $order['payment_data_parsed'] = json_decode($order['payment_data'] ?? '{}', true) ?: [];

        echo json_encode([
            'success' => true,
            'order' => $order
        ]);
        exit;
    }
}
