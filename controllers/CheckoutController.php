<?php
/**
 * Controlador de Checkout Público y Procesamiento de Pagos Flow.cl
 */

class CheckoutController extends Controller {

    public function index(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $productId = (int)($_GET['id'] ?? $_GET['product_id'] ?? 0);
        $fromCart = isset($_GET['from']) && $_GET['from'] === 'cart';
        $cart = $_SESSION['cart'] ?? [];

        $productModel = new Product();
        $gatewayModel = new PaymentGateway();

        $product = null;
        if ($productId > 0) {
            $product = $productModel->findWithCategory($productId);
        }

        // Fallback desde JSON si la BD no está sincronizada
        if (!$product && $productId > 0) {
            $prodFile = ROOT_PATH . '/database/extracted_products.json';
            if (file_exists($prodFile)) {
                $rawProds = json_decode(file_get_contents($prodFile), true) ?: [];
                foreach ($rawProds as $p) {
                    if ((int)$p['id'] === $productId) {
                        $product = [
                            'id' => $p['id'],
                            'model' => $p['model'],
                            'name' => $p['name'],
                            'price' => $p['price'] ?? 150000.00,
                            'category_name' => ucfirst($p['cat_slug']),
                            'image' => $p['image'],
                            'specs_json' => $p['specs']
                        ];
                        break;
                    }
                }
            }
        }

        $flowConfig = $gatewayModel->getFlowConfig();

        // Calcular total si viene desde el carro
        $cartTotal = 0;
        $cartItemsSummary = '';
        if ($fromCart && !empty($cart)) {
            $subtotal = 0;
            $itemsList = [];
            foreach ($cart as $it) {
                $subtotal += ($it['price'] * $it['quantity']);
                $itemsList[] = $it['model'] . ' (x' . $it['quantity'] . ')';
            }
            $iva = round($subtotal * 0.19);
            $cartTotal = $subtotal + $iva;
            $cartItemsSummary = implode(', ', $itemsList);
        }

        require_once VIEWS_PATH . '/frontend/checkout.php';
    }

    public function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $gatewayModel = new PaymentGateway();
        $flowConfig = $gatewayModel->getFlowConfig();

        if (empty($flowConfig['is_active'])) {
            die('La pasarela de pago Flow.cl se encuentra deshabilitada temporalmente.');
        }

        $clientName = trim($_POST['nombre'] ?? '');
        $clientEmail = trim($_POST['email'] ?? '');
        $clientPhone = trim($_POST['telefono'] ?? '');
        $company = trim($_POST['empresa'] ?? '');
        $productId = !empty($_POST['product_id']) ? (int)$_POST['product_id'] : null;
        $productName = trim($_POST['product_name'] ?? 'Equipo Industrial VICTORQ');
        $amount = (int)($_POST['amount'] ?? 50000);

        if (empty($clientName) || empty($clientEmail) || $amount <= 0) {
            die('Datos del comprador o monto inválido.');
        }

        $commerceOrder = 'VQ-' . date('ymd') . '-' . rand(1000, 9999);

        // Registrar orden previa en base de datos
        $orderModel = new PaymentOrder();
        $orderId = $orderModel->create([
            'commerce_order' => $commerceOrder,
            'product_id' => $productId,
            'product_name' => $productName,
            'amount' => $amount,
            'currency' => $flowConfig['currency'] ?? 'CLP',
            'customer_name' => $clientName,
            'customer_email' => $clientEmail,
            'customer_phone' => $clientPhone,
            'status' => 'pending'
        ]);

        $flowService = new FlowService();
        $response = $flowService->createPayment([
            'commerceOrder' => $commerceOrder,
            'subject' => 'Pago: ' . substr($productName, 0, 80),
            'currency' => $flowConfig['currency'] ?? 'CLP',
            'amount' => $amount,
            'email' => $clientEmail,
            'urlConfirmation' => BASE_URL . '/payment_webhook.php',
            'urlReturn' => BASE_URL . '/payment_return.php',
            'optional' => [
                'company' => $company,
                'phone' => $clientPhone,
                'product_id' => $productId
            ]
        ]);

        if ($response['success']) {
            if ($orderId > 0) {
                $orderModel->update($orderId, [
                    'flow_token' => $response['token'],
                    'flow_order' => $response['flowOrder'] ?? null
                ]);
            }
            header('Location: ' . $response['redirect_url']);
            exit;
        } else {
            echo '<div style="font-family:sans-serif;max-width:600px;margin:50px auto;padding:30px;border:2px solid #e11d48;background:#fff1f2;border-radius:4px;">';
            echo '<h3 style="color:#9f1239;margin-top:0;">Error al Iniciar Pago con Flow.cl</h3>';
            echo '<p style="color:#4c0519;">' . htmlspecialchars($response['message']) . '</p>';
            echo '<a href="' . BASE_URL . '/checkout.php?id=' . $productId . '" style="display:inline-block;padding:10px 20px;background:#015B91;color:#fff;text-decoration:none;font-weight:bold;">Volver al Checkout</a>';
            echo '</div>';
            exit;
        }
    }

    public function confirmation(): void {
        $token = $_POST['token'] ?? $_GET['token'] ?? '';
        if (empty($token)) {
            http_response_code(400);
            echo 'Token requerido';
            exit;
        }

        $flowService = new FlowService();
        $statusResponse = $flowService->getPaymentStatus($token);

        if ($statusResponse['success']) {
            $orderModel = new PaymentOrder();
            $commerceOrder = $statusResponse['commerce_order'] ?? '';
            
            $existingOrder = $orderModel->findByCommerceOrder($commerceOrder);
            if (!$existingOrder) {
                $existingOrder = $orderModel->findByToken($token);
            }

            if ($existingOrder) {
                $orderModel->update($existingOrder['id'], [
                    'flow_order' => $statusResponse['flow_order'],
                    'status' => $statusResponse['status'],
                    'payment_data' => json_encode($statusResponse['raw'], JSON_UNESCAPED_UNICODE)
                ]);
            }

            http_response_code(200);
            echo 'OK';
            exit;
        }

        http_response_code(400);
        echo 'Error consultando estado Flow';
        exit;
    }

    public function result(): void {
        $token = $_POST['token'] ?? $_GET['token'] ?? '';
        $order = null;
        $statusData = null;

        if (!empty($token)) {
            $flowService = new FlowService();
            $statusResponse = $flowService->getPaymentStatus($token);

            if ($statusResponse['success']) {
                $statusData = $statusResponse;
                $orderModel = new PaymentOrder();
                $commerceOrder = $statusResponse['commerce_order'] ?? '';

                $order = $orderModel->findByCommerceOrder($commerceOrder);
                if (!$order) {
                    $order = $orderModel->findByToken($token);
                }

                if ($order) {
                    $orderModel->update($order['id'], [
                        'flow_order' => $statusResponse['flow_order'],
                        'status' => $statusResponse['status'],
                        'payment_data' => json_encode($statusResponse['raw'], JSON_UNESCAPED_UNICODE)
                    ]);
                    $order['status'] = $statusResponse['status'];
                    $order['flow_order'] = $statusResponse['flow_order'];
                }
            }
        }

        require_once VIEWS_PATH . '/frontend/payment_result.php';
    }
}
