<?php
/**
 * Controlador de Cotizaciones (Panel de Administración)
 * Soporte para Cotizaciones Multiproducto y Descuentos por Producto / General
 */

class QuoteController extends Controller {

    public function index(): void {
        Auth::requirePermission('quotes', 'view');

        $quoteModel = new Quote();
        $quotes = $quoteModel->getAllWithProduct();
        $counts = $quoteModel->getCountsByStatus();

        $this->render('admin/quotes/index', [
            'quotes' => $quotes,
            'counts' => $counts
        ]);
    }

    public function create(): void {
        Auth::requirePermission('quotes', 'create');

        $productModel = new Product();
        $products = $productModel->getAllWithCategory('p.name ASC');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientName = trim($_POST['client_name'] ?? '');
            $clientEmail = trim($_POST['client_email'] ?? '');
            $clientPhone = trim($_POST['client_phone'] ?? '');
            $company = trim($_POST['company'] ?? '');
            $rut = trim($_POST['rut'] ?? '');
            $faena = trim($_POST['faena'] ?? '');
            $message = trim($_POST['message'] ?? '');
            $status = in_array($_POST['status'] ?? '', ['pending', 'in_review', 'quoted', 'closed']) ? $_POST['status'] : 'quoted';
            $adminNotes = trim($_POST['admin_notes'] ?? '');

            if (empty($clientName) || empty($clientEmail)) {
                $this->setFlash('error', 'El nombre del solicitante y el correo electrónico son obligatorios.');
                $this->render('admin/quotes/form', [
                    'products' => $products,
                    'quote' => $_POST
                ]);
                return;
            }

            // Procesar múltiples productos
            $rawItems = $_POST['items'] ?? [];
            $itemsList = [];
            $subtotalGross = 0;
            $totalItemDiscounts = 0;
            $mainProductId = null;

            foreach ($rawItems as $raw) {
                $pId = (int)($raw['product_id'] ?? 0);
                if ($pId <= 0) continue;

                $pData = $productModel->find($pId);
                if (!$pData) continue;

                if ($mainProductId === null) {
                    $mainProductId = $pId;
                }

                $qty = max(1, (int)($raw['quantity'] ?? 1));
                $unitPrice = !empty($raw['price']) ? (float)$raw['price'] : (float)($pData['price'] ?? 150000);
                $discType = ($raw['discount_type'] ?? '%') === '$' ? '$' : '%';
                $discVal = max(0, (float)($raw['discount_val'] ?? 0));

                $lineGross = $unitPrice * $qty;
                $lineDiscount = 0;
                if ($discVal > 0) {
                    $lineDiscount = ($discType === '%') ? ($lineGross * ($discVal / 100)) : min($lineGross, $discVal);
                }
                $lineNet = $lineGross - $lineDiscount;

                $subtotalGross += $lineGross;
                $totalItemDiscounts += $lineDiscount;

                $itemsList[] = [
                    'product_id' => $pId,
                    'model' => $pData['model'],
                    'name' => $pData['name'],
                    'image' => $pData['image'],
                    'category_slug' => $pData['category_slug'] ?? 'equipos',
                    'specs' => json_decode($pData['specs_json'] ?? '{}', true) ?: [],
                    'quantity' => $qty,
                    'price' => $unitPrice,
                    'discount_type' => $discType,
                    'discount_val' => $discVal,
                    'discount_amount' => $lineDiscount,
                    'line_total' => $lineNet
                ];
            }

            // Si no se agregaron productos válidos, crear al menos 1 por defecto
            if (empty($itemsList)) {
                $firstProd = $products[0] ?? null;
                if ($firstProd) {
                    $mainProductId = $firstProd['id'];
                    $unitPrice = (float)($firstProd['price'] ?? 150000);
                    $itemsList[] = [
                        'product_id' => $firstProd['id'],
                        'model' => $firstProd['model'],
                        'name' => $firstProd['name'],
                        'image' => $firstProd['image'],
                        'category_slug' => 'equipos',
                        'specs' => [],
                        'quantity' => 1,
                        'price' => $unitPrice,
                        'discount_type' => '%',
                        'discount_val' => 0,
                        'discount_amount' => 0,
                        'line_total' => $unitPrice
                    ];
                    $subtotalGross = $unitPrice;
                }
            }

            // Descuento General
            $globalDiscType = ($_POST['global_discount_type'] ?? '%') === '$' ? '$' : '%';
            $globalDiscVal = max(0, (float)($_POST['global_discount_val'] ?? 0));
            $subtotalAfterItemDiscounts = $subtotalGross - $totalItemDiscounts;
            $globalDiscountAmount = 0;
            if ($globalDiscVal > 0) {
                $globalDiscountAmount = ($globalDiscType === '%') ? ($subtotalAfterItemDiscounts * ($globalDiscVal / 100)) : min($subtotalAfterItemDiscounts, $globalDiscVal);
            }

            $totalDiscounts = $totalItemDiscounts + $globalDiscountAmount;
            $subtotalNeto = max(0, $subtotalGross - $totalDiscounts);
            $iva = round($subtotalNeto * 0.19);
            $total = $subtotalNeto + $iva;

            $productInterest = count($itemsList) > 1 
                ? "Cotización Presupuesto (" . count($itemsList) . " equipos)" 
                : ($itemsList[0]['model'] . " — " . $itemsList[0]['name']);

            // Armar texto descriptivo para el mensaje
            $msgLines = [];
            $msgLines[] = "Cotización Técnica Multiproducto emitida desde el Panel de Administración.";
            if ($rut) $msgLines[] = "RUT Empresa: {$rut}";
            if ($faena) $msgLines[] = "Faena/Destino: {$faena}";
            $msgLines[] = "\nDetalle de Equipos Cotizados:";
            foreach ($itemsList as $it) {
                $discTxt = $it['discount_amount'] > 0 ? " (Desc: -$" . number_format($it['discount_amount'], 0, ',', '.') . ")" : "";
                $msgLines[] = "• {$it['model']} | {$it['name']} — Cant: {$it['quantity']} x $" . number_format($it['price'], 0, ',', '.') . " = $" . number_format($it['line_total'], 0, ',', '.') . " CLP{$discTxt}";
            }
            if ($globalDiscountAmount > 0) {
                $msgLines[] = "\nDescuento Comercial Global: -$" . number_format($globalDiscountAmount, 0, ',', '.') . " CLP";
            }
            $msgLines[] = "Subtotal Neto: $" . number_format($subtotalNeto, 0, ',', '.') . " CLP";
            $msgLines[] = "I.V.A. (19%): $" . number_format($iva, 0, ',', '.') . " CLP";
            $msgLines[] = "TOTAL GENERAL: $" . number_format($total, 0, ',', '.') . " CLP";
            if ($message) $msgLines[] = "\nObservaciones: {$message}";

            $companyFull = $company;
            if ($rut) {
                $companyFull .= (empty($companyFull) ? '' : ' ') . "(RUT: {$rut})";
            }

            $quoteModel = new Quote();
            $newId = $quoteModel->create([
                'product_id' => $mainProductId,
                'client_name' => $clientName,
                'client_email' => $clientEmail,
                'client_phone' => $clientPhone,
                'company' => $companyFull,
                'product_interest' => $productInterest,
                'items_json' => json_encode($itemsList, JSON_UNESCAPED_UNICODE),
                'discount_percent' => ($globalDiscType === '%') ? $globalDiscVal : 0.00,
                'discount_amount' => $totalDiscounts,
                'subtotal_neto' => $subtotalNeto,
                'iva_amount' => $iva,
                'total_amount' => $total,
                'message' => implode("\n", $msgLines),
                'status' => $status,
                'admin_notes' => $adminNotes,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
            ]);

            $this->setFlash('success', '¡Cotización #' . $newId . ' con ' . count($itemsList) . ' producto(s) creada exitosamente!');
            $this->redirect(ADMIN_URL . '/?c=quote&a=view&id=' . $newId);
        }

        $this->render('admin/quotes/form', [
            'products' => $products,
            'quote' => [
                'status' => 'quoted',
                'discount_val' => 0
            ]
        ]);
    }

    public function view(): void {
        Auth::requirePermission('quotes', 'view');

        $id = (int)($_GET['id'] ?? 0);
        $quoteModel = new Quote();
        $quote = $quoteModel->findWithProduct($id);

        if (!$quote) {
            $this->setFlash('error', 'Solicitud de cotización no encontrada.');
            $this->redirect(ADMIN_URL . '/?c=quote');
        }

        // Si se actualiza el estado o notas
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requirePermission('quotes', 'edit');

            $status = $_POST['status'] ?? $quote['status'];
            $adminNotes = trim($_POST['admin_notes'] ?? '');

            $quoteModel->update($id, [
                'status' => $status,
                'admin_notes' => $adminNotes
            ]);

            $this->setFlash('success', 'Cotización #' . $id . ' actualizada correctamente.');
            $this->redirect(ADMIN_URL . '/?c=quote&a=view&id=' . $id);
        }

        // Parsear items_json si existe
        $items = [];
        if (!empty($quote['items_json'])) {
            $items = json_decode($quote['items_json'], true) ?: [];
        }

        $product = null;
        if (!empty($quote['product_id'])) {
            $productModel = new Product();
            $product = $productModel->find((int)$quote['product_id']);
        }

        $this->render('admin/quotes/view', [
            'quote' => $quote,
            'items' => $items,
            'product' => $product
        ]);
    }

    public function pdf(): void {
        Auth::requirePermission('quotes', 'view');

        $id = (int)($_GET['id'] ?? 0);
        header('Location: ' . BASE_URL . '/quote_pdf.php?quote_id=' . $id);
        exit;
    }

    public function delete(): void {
        Auth::requirePermission('quotes', 'delete');

        $id = (int)($_GET['id'] ?? 0);
        $quoteModel = new Quote();
        $quote = $quoteModel->find($id);

        if ($quote) {
            $quoteModel->delete($id);
            $this->setFlash('success', 'Cotización eliminada correctamente.');
        }

        $this->redirect(ADMIN_URL . '/?c=quote');
    }
}
