<?php
/**
 * Controlador de Carro de Compras (Shopping Cart)
 * Gestión de artículos en sesión con sincronización en tiempo real y soporte para Flow.cl
 */

class CartController extends Controller {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function index(): void {
        $cart = $_SESSION['cart'] ?? [];
        $subtotal = 0;
        $totalItems = 0;

        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
            $totalItems += $item['quantity'];
        }

        $iva = round($subtotal * 0.19);
        $total = $subtotal + $iva;

        $gatewayModel = new PaymentGateway();
        $flowConfig = $gatewayModel->getFlowConfig();

        require_once VIEWS_PATH . '/frontend/cart.php';
    }

    public function add(): void {
        header('Content-Type: application/json; charset=utf-8');

        $productId = (int)($_POST['product_id'] ?? $_GET['product_id'] ?? 0);
        $qty = max(1, (int)($_POST['quantity'] ?? $_GET['quantity'] ?? 1));

        if ($productId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Producto inválido.']);
            exit;
        }

        $productModel = new Product();
        $product = $productModel->findWithCategory($productId);

        if (!$product) {
            $prodFile = ROOT_PATH . '/database/extracted_products.json';
            if (file_exists($prodFile)) {
                $rawProds = json_decode(file_get_contents($prodFile), true) ?: [];
                foreach ($rawProds as $p) {
                    if ((int)$p['id'] === $productId) {
                        $product = [
                            'id' => $p['id'],
                            'model' => $p['model'],
                            'name' => $p['name'],
                            'price' => 150000.00,
                            'image' => $p['image'],
                            'datasheet_pdf' => $p['datasheet_pdf'] ?? null,
                            'category_slug' => $p['cat_slug'],
                            'category_name' => ucfirst($p['cat_slug'])
                        ];
                        break;
                    }
                }
            }
        }

        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Producto no encontrado.']);
            exit;
        }

        $price = !empty($product['price']) ? (float)$product['price'] : 150000.00;

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $qty;
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => (int)$product['id'],
                'model' => $product['model'],
                'name' => $product['name'],
                'price' => $price,
                'image' => $product['image'] ?? 'default.png',
                'datasheet_pdf' => $product['datasheet_pdf'] ?? null,
                'category_slug' => $product['category_slug'] ?? 'equipos',
                'quantity' => $qty
            ];
        }

        $totalItems = 0;
        $subtotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $totalItems += $item['quantity'];
            $subtotal += ($item['price'] * $item['quantity']);
        }

        echo json_encode([
            'success' => true,
            'message' => '¡' . htmlspecialchars($product['model']) . ' añadido al carro de compras!',
            'total_items' => $totalItems,
            'subtotal' => $subtotal,
            'item' => $_SESSION['cart'][$productId]
        ]);
        exit;
    }

    public function update(): void {
        header('Content-Type: application/json; charset=utf-8');

        $productId = (int)($_POST['product_id'] ?? 0);
        $qty = (int)($_POST['quantity'] ?? 1);

        if ($productId <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID inválido']);
            exit;
        }

        if ($qty <= 0) {
            unset($_SESSION['cart'][$productId]);
        } else {
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity'] = $qty;
            }
        }

        $totalItems = 0;
        $subtotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $totalItems += $item['quantity'];
            $subtotal += ($item['price'] * $item['quantity']);
        }

        $iva = round($subtotal * 0.19);
        $total = $subtotal + $iva;

        echo json_encode([
            'success' => true,
            'total_items' => $totalItems,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total
        ]);
        exit;
    }

    public function remove(): void {
        $productId = (int)($_POST['product_id'] ?? $_GET['id'] ?? 0);
        if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json; charset=utf-8');
            $totalItems = 0;
            $subtotal = 0;
            foreach ($_SESSION['cart'] as $item) {
                $totalItems += $item['quantity'];
                $subtotal += ($item['price'] * $item['quantity']);
            }
            $iva = round($subtotal * 0.19);
            $total = $subtotal + $iva;

            echo json_encode([
                'success' => true,
                'total_items' => $totalItems,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total
            ]);
            exit;
        }

        header('Location: ' . BASE_URL . '/cart.php');
        exit;
    }

    public function clear(): void {
        $_SESSION['cart'] = [];

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => true, 'total_items' => 0, 'subtotal' => 0, 'total' => 0]);
            exit;
        }

        header('Location: ' . BASE_URL . '/cart.php');
        exit;
    }

    public function count(): void {
        header('Content-Type: application/json; charset=utf-8');
        $totalItems = 0;
        $subtotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $totalItems += $item['quantity'];
            $subtotal += ($item['price'] * $item['quantity']);
        }
        echo json_encode([
            'success' => true,
            'total_items' => $totalItems,
            'subtotal' => $subtotal
        ]);
        exit;
    }

    public function quotePdf(): void {
        $quoteId = (int)($_GET['quote_id'] ?? 0);
        $cart = $_SESSION['cart'] ?? [];

        // Si se solicita una cotización guardada desde el panel administrativo
        if ($quoteId > 0) {
            $quoteModel = new Quote();
            $quote = $quoteModel->findWithProduct($quoteId);
            if ($quote) {
                $compName = $quote['company'] ?? '';
                $rut = '';
                if (preg_match('/\(RUT:\s*([^)]+)\)/', $compName, $matches)) {
                    $rut = trim($matches[1]);
                    $compName = trim(str_replace($matches[0], '', $compName));
                }

                $company = [
                    'empresa' => $compName ?: ($quote['client_name'] . ' SpA'),
                    'rut' => $rut ?: '76.890.123-K',
                    'solicitante' => $quote['client_name'],
                    'email' => $quote['client_email'],
                    'telefono' => $quote['client_phone'] ?: APP_PHONE,
                    'faena' => 'Despacho a Faena',
                    'observaciones' => $quote['message'] ?? '',
                    'folio' => 'COT-' . date('Ymd', strtotime($quote['created_at'])) . '-' . sprintf('%03d', $quote['id']),
                    'fecha_emision' => date('d/m/Y', strtotime($quote['created_at'])),
                    'fecha_vencimiento' => date('d/m/Y', strtotime($quote['created_at'] . ' +15 days'))
                ];

                $enrichedCart = [];
                $savedItems = !empty($quote['items_json']) ? json_decode($quote['items_json'], true) : null;

                if (!empty($savedItems) && is_array($savedItems)) {
                    foreach ($savedItems as $it) {
                        $enrichedCart[] = [
                            'id' => $it['product_id'] ?? 1,
                            'model' => $it['model'] ?? 'VICTORQ-EQUIP',
                            'name' => $it['name'] ?? 'Equipo Hidráulico 700 Bar',
                            'image' => $it['image'] ?? 'default.png',
                            'price' => (float)$it['price'],
                            'quantity' => (int)$it['quantity'],
                            'discount_type' => $it['discount_type'] ?? '%',
                            'discount_val' => (float)($it['discount_val'] ?? 0),
                            'discount_amount' => (float)($it['discount_amount'] ?? 0),
                            'subtotal' => (float)($it['line_total'] ?? ($it['price'] * $it['quantity'])),
                            'category_slug' => $it['category_slug'] ?? 'equipos',
                            'specs' => $it['specs'] ?? ['Presión' => '700 bar', 'Calibración' => 'Certificada ISO 9001']
                        ];
                    }
                } else {
                    $unitPrice = !empty($quote['product_price']) ? (float)$quote['product_price'] : 150000.00;
                    $enrichedCart[] = [
                        'id' => $quote['product_id'] ?? 1,
                        'model' => $quote['product_model'] ?? 'VICTORQ-EQUIP',
                        'name' => $quote['product_name'] ?? ($quote['product_interest'] ?: 'Equipo Hidráulico Industrial 700 Bar'),
                        'image' => $quote['product_image'] ?? 'default.png',
                        'price' => $unitPrice,
                        'quantity' => 1,
                        'discount_type' => '%',
                        'discount_val' => 0,
                        'discount_amount' => 0,
                        'subtotal' => $unitPrice,
                        'category_slug' => 'equipos',
                        'specs' => json_decode($quote['specs_json'] ?? '{}', true) ?: ['Presión' => '700 bar', 'Calibración' => 'Certificada ISO 9001']
                    ];
                }

                $subtotalNeto = (float)($quote['subtotal_neto'] ?? 0);
                $totalDiscounts = (float)($quote['discount_amount'] ?? 0);
                $iva = (float)($quote['iva_amount'] ?? round($subtotalNeto * 0.19));
                $total = (float)($quote['total_amount'] ?? ($subtotalNeto + $iva));
                $subtotal = $subtotalNeto > 0 ? $subtotalNeto : array_sum(array_column($enrichedCart, 'subtotal'));
                $subtotalGross = $subtotal + $totalDiscounts;

                require_once VIEWS_PATH . '/frontend/quote_pdf.php';
                exit;
            }
        }

        if (empty($cart)) {
            header('Location: ' . BASE_URL . '/cart.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $empresa = trim($_POST['empresa'] ?? '');
            $rut = trim($_POST['rut'] ?? '');
            $solicitante = trim($_POST['solicitante'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $faena = trim($_POST['faena'] ?? '');
            $observaciones = trim($_POST['observaciones'] ?? '');

            $_SESSION['quote_company'] = [
                'empresa' => $empresa,
                'rut' => $rut,
                'solicitante' => $solicitante,
                'email' => $email,
                'telefono' => $telefono,
                'faena' => $faena,
                'observaciones' => $observaciones,
                'folio' => 'COT-' . date('Ymd') . '-' . rand(100, 999),
                'fecha_emision' => date('d/m/Y'),
                'fecha_vencimiento' => date('d/m/Y', strtotime('+15 days'))
            ];

            // Guardar en la tabla quotes de la base de datos para seguimiento del equipo de ventas
            try {
                $quoteModel = new Quote();
                $itemsList = [];
                $subtotal = 0;
                foreach ($cart as $it) {
                    $subtotal += ($it['price'] * $it['quantity']);
                    $itemsList[] = "- {$it['model']} | {$it['name']} (Cant: {$it['quantity']} x $" . number_format($it['price'], 0, ',', '.') . ")";
                }
                $iva = round($subtotal * 0.19);
                $total = $subtotal + $iva;

                $msg = "Cotización Formal PDF generada desde el Carro de Compras.\n";
                $msg .= "RUT Empresa: {$rut}\n";
                $msg .= "Faena/Destino: {$faena}\n";
                $msg .= "Validez: 15 Días Corridos (Hasta " . date('d/m/Y', strtotime('+15 days')) . ")\n";
                $msg .= "Observaciones: {$observaciones}\n\n";
                $msg .= "Detalle de Equipos:\n" . implode("\n", $itemsList) . "\n\n";
                $msg .= "Subtotal Neto: $" . number_format($subtotal, 0, ',', '.') . " CLP\n";
                $msg .= "IVA (19%): $" . number_format($iva, 0, ',', '.') . " CLP\n";
                $msg .= "Total General: $" . number_format($total, 0, ',', '.') . " CLP";

                $quoteModel->create([
                    'product_id' => null,
                    'client_name' => $solicitante,
                    'client_email' => $email,
                    'client_phone' => $telefono,
                    'company' => $empresa . ($rut ? " (RUT: {$rut})" : ''),
                    'product_interest' => 'Cotización Carro (' . count($cart) . ' equipos)',
                    'message' => $msg,
                    'status' => 'pending',
                    'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
                ]);
            } catch (Exception $e) {
                // Continuar si la BD no está disponible
            }

            header('Location: ' . BASE_URL . '/quote_pdf.php');
            exit;
        }

        $company = $_SESSION['quote_company'] ?? [
            'empresa' => 'Minera Escondida Ltda.',
            'rut' => '76.123.456-7',
            'solicitante' => 'Ing. Juan Pérez',
            'email' => 'adquisiciones@empresa.cl',
            'telefono' => '+56 9 8765 4321',
            'faena' => 'Faena Cordillera / Antofagasta',
            'observaciones' => 'Despacho con certificación de calibración individual.',
            'folio' => 'COT-' . date('Ymd') . '-' . rand(100, 999),
            'fecha_emision' => date('d/m/Y'),
            'fecha_vencimiento' => date('d/m/Y', strtotime('+15 days'))
        ];

        // Obtener especificaciones completas de los productos en el carro
        $productModel = new Product();
        $enrichedCart = [];
        $subtotal = 0;

        foreach ($cart as $item) {
            $pData = $productModel->find((int)$item['id']);
            $specs = [];
            if ($pData && !empty($pData['specs_json'])) {
                $specs = is_array($pData['specs_json']) ? $pData['specs_json'] : (json_decode($pData['specs_json'], true) ?: []);
            }
            $itemSubtotal = $item['price'] * $item['quantity'];
            $subtotal += $itemSubtotal;

            $enrichedCart[] = array_merge($item, [
                'specs' => $specs,
                'subtotal' => $itemSubtotal
            ]);
        }

        $iva = round($subtotal * 0.19);
        $total = $subtotal + $iva;

        require_once VIEWS_PATH . '/frontend/quote_pdf.php';
    }
}
