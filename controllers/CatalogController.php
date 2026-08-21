<?php
/**
 * Controlador del Catálogo Público Web VICTORQ
 */

class CatalogController extends Controller {

    public function index(): void {
        $categoryModel = new Category();
        $productModel = new Product();

        $categories = $categoryModel->getActiveCategories();
        $products = $productModel->getActiveByCategory();

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
                        'category_name' => ucfirst($p['cat_slug']),
                        'image' => $p['image'],
                        'specs_json' => $p['specs']
                    ];
                }
            }
        }

        // Renderizar vista del catálogo público
        require_once VIEWS_PATH . '/frontend/catalog.php';
    }

    public function category(string $slugOrId = ''): void {
        $categoryModel = new Category();
        $productModel = new Product();

        $param = !empty($slugOrId) ? $slugOrId : ($_GET['slug'] ?? $_GET['cat'] ?? $_GET['id'] ?? '');
        $category = null;

        if (!empty($param)) {
            $category = $categoryModel->findBySlugOrId($param);
        }

        // Fallback desde JSON si la BD no está sincronizada
        if (!$category) {
            $catFile = ROOT_PATH . '/database/extracted_categories.json';
            if (file_exists($catFile)) {
                $rawCats = json_decode(file_get_contents($catFile), true) ?: [];
                foreach ($rawCats as $c) {
                    if ($c['slug'] === $param || (string)($c['id'] ?? '') === (string)$param) {
                        $category = $c;
                        break;
                    }
                }
            }
        }

        if (!$category) {
            header('Location: ' . BASE_URL . '/index.php#departamentos');
            exit;
        }

        $allCategories = $categoryModel->getActiveCategories();
        if (empty($allCategories)) {
            $catFile = ROOT_PATH . '/database/extracted_categories.json';
            if (file_exists($catFile)) {
                $allCategories = json_decode(file_get_contents($catFile), true) ?: [];
            }
        }

        $products = $productModel->getActiveByCategory($category['slug']);
        if (empty($products)) {
            $prodFile = ROOT_PATH . '/database/extracted_products.json';
            if (file_exists($prodFile)) {
                $rawProds = json_decode(file_get_contents($prodFile), true) ?: [];
                $products = [];
                foreach ($rawProds as $p) {
                    if ($p['cat_slug'] === $category['slug']) {
                        $products[] = [
                            'id' => $p['id'],
                            'model' => $p['model'],
                            'name' => $p['name'],
                            'description' => $p['description'] ?? '',
                            'category_slug' => $p['cat_slug'],
                            'category_name' => $category['name'],
                            'image' => $p['image'],
                            'specs_json' => $p['specs']
                        ];
                    }
                }
            }
        }

        // Renderizar vista de la categoría
        require_once VIEWS_PATH . '/frontend/category_products.php';
    }

    public function detail(int $productId = 0): void {
        $productModel = new Product();
        $categoryModel = new Category();

        $id = $productId > 0 ? $productId : (int)($_GET['id'] ?? 0);
        $product = null;

        if ($id > 0) {
            $product = $productModel->findWithCategory($id);
        }

        // Fallback desde JSON si la base de datos está vacía o el producto no se encontró en MySQL
        if (!$product) {
            $prodFile = ROOT_PATH . '/database/extracted_products.json';
            if (file_exists($prodFile)) {
                $rawProds = json_decode(file_get_contents($prodFile), true) ?: [];
                foreach ($rawProds as $p) {
                    if ((int)$p['id'] === $id || $p['model'] === ($_GET['slug'] ?? '') || $p['model'] === ($_GET['model'] ?? '')) {
                        $product = [
                            'id' => $p['id'],
                            'category_id' => 1,
                            'model' => $p['model'],
                            'name' => $p['name'],
                            'description' => $p['description'] ?? 'Herramienta de alto rendimiento para aplicaciones críticas de torque y potencia hidráulica de 700 bar en faenas mineras e industriales.',
                            'category_slug' => $p['cat_slug'],
                            'category_name' => ucfirst($p['cat_slug']),
                            'image' => $p['image'],
                            'datasheet_pdf' => $p['datasheet_pdf'] ?? null,
                            'specs_json' => $p['specs'],
                            'is_featured' => 1,
                            'is_active' => 1
                        ];
                        break;
                    }
                }
            }
        }

        if (!$product) {
            header('Location: ' . BASE_URL . '/index.php#catalogo');
            exit;
        }

        // Decodificar especificaciones si vienen como string JSON
        if (is_string($product['specs_json'] ?? null)) {
            $product['specs'] = json_decode($product['specs_json'], true) ?: [];
        } elseif (is_array($product['specs_json'] ?? null)) {
            $product['specs'] = $product['specs_json'];
        } else {
            $product['specs'] = [];
        }

        $categories = $categoryModel->getActiveCategories();
        $relatedProducts = $productModel->getRelatedProducts((int)($product['category_id'] ?? 0), (int)$product['id'], 4);

        // Renderizar vista de detalle de producto
        require_once VIEWS_PATH . '/frontend/product_detail.php';
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
