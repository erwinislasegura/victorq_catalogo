<?php
/**
 * Controlador de Contacto (Página Pública y Panel de Administración)
 */

class ContactController extends Controller {

    // ==========================================
    // SECCIÓN PANEL DE ADMINISTRACIÓN (BACKEND)
    // ==========================================

    public function index(): void {
        Auth::requirePermission('contacts', 'view');

        $contactModel = new Contact();
        $statusFilter = $_GET['status'] ?? 'all';
        $contacts = $contactModel->getAllOrdered($statusFilter);
        $counts = $contactModel->getCountsByStatus();

        $this->render('admin/contacts/index', [
            'contacts' => $contacts,
            'counts' => $counts,
            'selectedStatus' => $statusFilter
        ]);
    }

    public function view(): void {
        Auth::requirePermission('contacts', 'view');

        $id = (int)($_GET['id'] ?? 0);
        $contactModel = new Contact();
        $contact = $contactModel->find($id);

        if (!$contact) {
            $this->setFlash('error', 'Mensaje de contacto no encontrado.');
            $this->redirect(ADMIN_URL . '/?c=contact');
        }

        // Si estaba como "unread" (no leído), marcar automáticamente como "read" (leído)
        if ($contact['status'] === 'unread') {
            $contactModel->update($id, ['status' => 'read']);
            $contact['status'] = 'read';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requirePermission('contacts', 'edit');

            $status = in_array($_POST['status'] ?? '', ['unread', 'read', 'responded', 'archived']) ? $_POST['status'] : $contact['status'];
            $adminNotes = trim($_POST['admin_notes'] ?? '');

            $contactModel->update($id, [
                'status' => $status,
                'admin_notes' => $adminNotes
            ]);

            $this->setFlash('success', 'Mensaje de contacto #' . $id . ' actualizado correctamente.');
            $this->redirect(ADMIN_URL . '/?c=contact&a=view&id=' . $id);
        }

        $this->render('admin/contacts/view', [
            'contact' => $contact
        ]);
    }

    public function delete(): void {
        Auth::requirePermission('contacts', 'delete');

        $id = (int)($_GET['id'] ?? 0);
        $contactModel = new Contact();
        $contact = $contactModel->find($id);

        if ($contact) {
            $contactModel->delete($id);
            $this->setFlash('success', 'Mensaje de contacto eliminado correctamente.');
        }

        $this->redirect(ADMIN_URL . '/?c=contact');
    }

    // ==========================================
    // SECCIÓN PÁGINA PÚBLICA (FRONTEND)
    // ==========================================

    public function publicPage(): void {
        require_once VIEWS_PATH . '/frontend/contact.php';
    }

    public function submit(): void {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $rut = trim($_POST['rut'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? 'Consulta General');
        $message = trim($_POST['message'] ?? '');

        if (empty($name) || empty($company) || empty($email) || empty($phone) || empty($message)) {
            echo json_encode(['success' => false, 'message' => 'Por favor complete todos los campos obligatorios (*)']);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'El correo electrónico ingresado no tiene un formato válido.']);
            exit;
        }

        $contactModel = new Contact();
        $newId = $contactModel->create([
            'name' => $name,
            'company' => $company,
            'rut' => $rut,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'status' => 'unread',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
        ]);

        if ($newId > 0) {
            echo json_encode([
                'success' => true,
                'message' => '¡Su mensaje ha sido enviado exitosamente! Un especialista técnico de VICTORQ se pondrá en contacto con usted a la brevedad.',
                'contact_id' => $newId
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No fue posible registrar su mensaje. Por favor contáctenos directamente al teléfono de asistencia.']);
        }
        exit;
    }
}
