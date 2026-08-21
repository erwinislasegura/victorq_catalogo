<?php
/**
 * Controlador de Productos
 */

class ProductController extends Controller {

    public function index(): void {
        Auth::requirePermission('products', 'view');

        $productModel = new Product();
        $categoryModel = new Category();

        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
        
        if ($categoryId > 0) {
            $products = $productModel->rawQuery(
                "SELECT p.*, c.name as category_name, c.slug as category_slug 
                 FROM products p 
                 LEFT JOIN categories c ON p.category_id = c.id 
                 WHERE p.category_id = :cat_id 
                 ORDER BY p.sort_order ASC, p.id ASC",
                ['cat_id' => $categoryId]
            );
        } else {
            $products = $productModel->getAllWithCategory();
        }

        $categories = $categoryModel->getAll('sort_order ASC');

        $this->render('admin/products/index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $categoryId
        ]);
    }

    public function create(): void {
        Auth::requirePermission('products', 'create');

        $categoryModel = new Category();
        $categories = $categoryModel->getActiveCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryId = (int)($_POST['category_id'] ?? 0);
            $model = trim($_POST['model'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = !empty($_POST['price']) ? (float)$_POST['price'] : 150000.00;
            $stock = isset($_POST['stock']) ? max(0, (int)$_POST['stock']) : 10;
            $minStock = isset($_POST['min_stock']) ? max(0, (int)$_POST['min_stock']) : 2;
            $sku = trim($_POST['sku'] ?? '');
            $warehouseLocation = trim($_POST['warehouse_location'] ?? 'Bodega Central - Santiago');
            $sortOrder = (int)($_POST['sort_order'] ?? 0);
            $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            
            // Especificaciones técnicas enviadas en clave-valor
            $specKeys = $_POST['spec_key'] ?? [];
            $specVals = $_POST['spec_val'] ?? [];
            $specs = [];
            for ($i = 0; $i < count($specKeys); $i++) {
                $k = trim($specKeys[$i]);
                $v = trim($specVals[$i] ?? '');
                if ($k !== '' && $v !== '') {
                    $specs[$k] = $v;
                }
            }

            if (empty($model) || empty($name) || $categoryId === 0) {
                $this->setFlash('error', 'Por favor complete todos los campos obligatorios.');
                $this->render('admin/products/form', [
                    'product' => $_POST,
                    'categories' => $categories,
                    'isEdit' => false
                ]);
                return;
            }

            // Manejo de imagen
            $imageName = 'default.png';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $fileTmp = $_FILES['image']['tmp_name'];
                $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
                
                if (in_array($fileExt, $allowed)) {
                    $imageName = 'prod_' . time() . '_' . rand(100, 999) . '.' . $fileExt;
                    move_uploaded_file($fileTmp, ASSETS_PATH . '/img/products/' . $imageName);
                }
            } elseif (!empty($_POST['existing_image'])) {
                $imageName = $_POST['existing_image'];
            }

            // Manejo de Ficha Técnica (Documento PDF / DOC / DOCX)
            $datasheetName = null;
            if (isset($_FILES['datasheet_pdf']) && $_FILES['datasheet_pdf']['error'] === UPLOAD_ERR_OK) {
                $docTmp = $_FILES['datasheet_pdf']['tmp_name'];
                $docExt = strtolower(pathinfo($_FILES['datasheet_pdf']['name'], PATHINFO_EXTENSION));
                $allowedDocs = ['pdf', 'doc', 'docx'];
                if (in_array($docExt, $allowedDocs)) {
                    $datasheetName = 'ficha_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower($model)) . '_' . time() . '.' . $docExt;
                    $destDir = ASSETS_PATH . '/docs/datasheets';
                    if (!is_dir($destDir)) {
                        mkdir($destDir, 0755, true);
                    }
                    move_uploaded_file($docTmp, $destDir . '/' . $datasheetName);
                }
            }

            $productModel = new Product();
            $newId = $productModel->create([
                'category_id' => $categoryId,
                'model' => $model,
                'sku' => $sku,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'stock' => $stock,
                'min_stock' => $minStock,
                'warehouse_location' => $warehouseLocation,
                'image' => $imageName,
                'datasheet_pdf' => $datasheetName,
                'specs_json' => json_encode($specs, JSON_UNESCAPED_UNICODE),
                'sort_order' => $sortOrder,
                'is_featured' => $isFeatured,
                'is_active' => $isActive
            ]);

            $this->setFlash('success', 'Producto creado exitosamente con su ficha técnica.');
            $this->redirect(ADMIN_URL . '/?c=product');
        }

        $this->render('admin/products/form', [
            'product' => ['sort_order' => 1, 'is_active' => 1, 'is_featured' => 0, 'price' => 150000.00],
            'categories' => $categories,
            'isEdit' => false
        ]);
    }

    public function edit(): void {
        Auth::requirePermission('products', 'edit');

        $id = (int)($_GET['id'] ?? 0);
        $productModel = new Product();
        $product = $productModel->find($id);

        if (!$product) {
            $this->setFlash('error', 'Producto no encontrado.');
            $this->redirect(ADMIN_URL . '/?c=product');
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getActiveCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryId = (int)($_POST['category_id'] ?? 0);
            $model = trim($_POST['model'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = !empty($_POST['price']) ? (float)$_POST['price'] : 150000.00;
            $stock = isset($_POST['stock']) ? max(0, (int)$_POST['stock']) : (int)($product['stock'] ?? 10);
            $minStock = isset($_POST['min_stock']) ? max(0, (int)$_POST['min_stock']) : (int)($product['min_stock'] ?? 2);
            $sku = trim($_POST['sku'] ?? ($product['sku'] ?? ''));
            $warehouseLocation = trim($_POST['warehouse_location'] ?? ($product['warehouse_location'] ?? 'Bodega Central - Santiago'));
            $sortOrder = (int)($_POST['sort_order'] ?? 0);
            $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            // Especificaciones técnicas
            $specKeys = $_POST['spec_key'] ?? [];
            $specVals = $_POST['spec_val'] ?? [];
            $specs = [];
            for ($i = 0; $i < count($specKeys); $i++) {
                $k = trim($specKeys[$i]);
                $v = trim($specVals[$i] ?? '');
                if ($k !== '' && $v !== '') {
                    $specs[$k] = $v;
                }
            }

            if (empty($model) || empty($name) || $categoryId === 0) {
                $this->setFlash('error', 'Por favor complete todos los campos obligatorios.');
                $this->render('admin/products/form', [
                    'product' => array_merge($product, $_POST),
                    'categories' => $categories,
                    'isEdit' => true
                ]);
                return;
            }

            // Manejo de imagen
            $imageName = $product['image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $fileTmp = $_FILES['image']['tmp_name'];
                $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
                
                if (in_array($fileExt, $allowed)) {
                    $imageName = 'prod_' . time() . '_' . rand(100, 999) . '.' . $fileExt;
                    move_uploaded_file($fileTmp, ASSETS_PATH . '/img/products/' . $imageName);
                }
            }

            // Manejo de Ficha Técnica (Documento PDF / DOC / DOCX)
            $datasheetName = $product['datasheet_pdf'] ?? null;
            if (!empty($_POST['remove_datasheet']) && $_POST['remove_datasheet'] == '1') {
                if ($datasheetName && file_exists(ASSETS_PATH . '/docs/datasheets/' . $datasheetName)) {
                    @unlink(ASSETS_PATH . '/docs/datasheets/' . $datasheetName);
                }
                $datasheetName = null;
            } elseif (isset($_FILES['datasheet_pdf']) && $_FILES['datasheet_pdf']['error'] === UPLOAD_ERR_OK) {
                $docTmp = $_FILES['datasheet_pdf']['tmp_name'];
                $docExt = strtolower(pathinfo($_FILES['datasheet_pdf']['name'], PATHINFO_EXTENSION));
                $allowedDocs = ['pdf', 'doc', 'docx'];
                if (in_array($docExt, $allowedDocs)) {
                    if ($datasheetName && file_exists(ASSETS_PATH . '/docs/datasheets/' . $datasheetName)) {
                        @unlink(ASSETS_PATH . '/docs/datasheets/' . $datasheetName);
                    }
                    $datasheetName = 'ficha_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower($model)) . '_' . time() . '.' . $docExt;
                    $destDir = ASSETS_PATH . '/docs/datasheets';
                    if (!is_dir($destDir)) {
                        mkdir($destDir, 0755, true);
                    }
                    move_uploaded_file($docTmp, $destDir . '/' . $datasheetName);
                }
            } elseif (!empty($_POST['existing_datasheet_pdf'])) {
                $datasheetName = $_POST['existing_datasheet_pdf'];
            }

            $productModel->update($id, [
                'category_id' => $categoryId,
                'model' => $model,
                'sku' => $sku,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'stock' => $stock,
                'min_stock' => $minStock,
                'warehouse_location' => $warehouseLocation,
                'image' => $imageName,
                'datasheet_pdf' => $datasheetName,
                'specs_json' => json_encode($specs, JSON_UNESCAPED_UNICODE),
                'sort_order' => $sortOrder,
                'is_featured' => $isFeatured,
                'is_active' => $isActive
            ]);

            $this->setFlash('success', 'Producto actualizado exitosamente.');
            $this->redirect(ADMIN_URL . '/?c=product');
        }

        $this->render('admin/products/form', [
            'product' => $product,
            'categories' => $categories,
            'isEdit' => true
        ]);
    }

    public function delete(): void {
        Auth::requirePermission('products', 'delete');

        $id = (int)($_GET['id'] ?? 0);
        $productModel = new Product();
        $product = $productModel->find($id);

        if ($product) {
            $productModel->delete($id);
            $this->setFlash('success', 'Producto eliminado correctamente.');
        } else {
            $this->setFlash('error', 'Producto no encontrado.');
        }

        $this->redirect(ADMIN_URL . '/?c=product');
    }

    public function toggle(): void {
        Auth::requirePermission('products', 'edit');

        $id = (int)($_GET['id'] ?? 0);
        $productModel = new Product();
        $product = $productModel->find($id);

        if ($product) {
            $newStatus = $product['is_active'] ? 0 : 1;
            $productModel->update($id, ['is_active' => $newStatus]);
            $this->setFlash('success', 'Estado del producto actualizado.');
        }

        $this->redirect(ADMIN_URL . '/?c=product');
    }
}
