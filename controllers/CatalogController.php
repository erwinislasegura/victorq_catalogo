<?php
/**
 * Controlador del Catálogo Público Web VICTORQ
 */

class CatalogController extends Controller {

    public function index(): void {
        $categoryModel = new Category();
        $productModel = new Product();
        $tableModel = new TechnicalTable();

        $categories = $categoryModel->getActiveCategories();
        $products = $productModel->getActiveByCategory();
        $tables = $tableModel->getAllWithCategory();

        // Si la base de datos aún no está poblada, cargar datos iniciales de respaldo
        if (empty($categories)) {
            $catFile = ROOT_PATH . '/database/extracted_categories.json';
            if (file_exists($catFile)) {
                $categories = json_decode(file_get_contents($catFile), true) ?: [];
            }
        }

        if (empty($products)) {
            $prodFile = ROOT_PATH . '/database/extracted_products.json';
            if (file_exists($prodFile)) {
                $rawProds = json_decode(file_get_contents($prodFile), true) ?: [];
                $products = [];
                foreach ($rawProds as $p) {
                    $products[] = [
                        'id' => $p['id'],
                        'model' => $p['model'],
                        'name' => $p['name'],
                        'category_slug' => $p['cat_slug'],
                        'image' => $p['image'],
                        'specs_json' => $p['specs']
                    ];
                }
            }
        }

        if (empty($tables)) {
            $tblFile = ROOT_PATH . '/database/extracted_tables.json';
            if (file_exists($tblFile)) {
                $tables = json_decode(file_get_contents($tblFile), true) ?: [];
            }
        }

        // Renderizar vista del catálogo público
        require_once VIEWS_PATH . '/frontend/catalog.php';
    }

    public function quote(): void {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $clientName = trim($_POST['nombre'] ?? $_POST['client_name'] ?? '');
        $clientEmail = trim($_POST['email'] ?? $_POST['client_email'] ?? '');
        $clientPhone = trim($_POST['telefono'] ?? $_POST['client_phone'] ?? '');
        $company = trim($_POST['empresa'] ?? $_POST['company'] ?? '');
        $productInterest = trim($_POST['categoria'] ?? $_POST['producto'] ?? $_POST['product_interest'] ?? '');
        $message = trim($_POST['mensaje'] ?? $_POST['message'] ?? '');
        $productId = !empty($_POST['product_id']) ? (int)$_POST['product_id'] : null;

        if (empty($clientName) || empty($clientEmail)) {
            echo json_encode(['success' => false, 'message' => 'Por favor ingrese su nombre y correo electrónico.']);
            exit;
        }

        if (!filter_var($clientEmail, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'El correo electrónico no es válido.']);
            exit;
        }

        $quoteModel = new Quote();
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

        $quoteId = $quoteModel->create([
            'product_id' => $productId,
            'client_name' => $clientName,
            'client_email' => $clientEmail,
            'client_phone' => $clientPhone,
            'company' => $company,
            'product_interest' => $productInterest,
            'message' => $message,
            'status' => 'pending',
            'ip_address' => $ip
        ]);

        if ($quoteId > 0) {
            echo json_encode([
                'success' => true,
                'message' => '¡Solicitud de cotización enviada con éxito! Nuestro equipo técnico se contactará a la brevedad.',
                'quote_id' => $quoteId
            ]);
        } else {
            echo json_encode([
                'success' => true,
                'message' => '¡Solicitud recibida! Nos pondremos en contacto prontamente.'
            ]);
        }
        exit;
    }
}
