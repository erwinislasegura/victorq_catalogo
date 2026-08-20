<?php
/**
 * Controlador de Usuarios
 */

class UserController extends Controller {

    public function index(): void {
        Auth::requirePermission('users', 'view');

        $userModel = new User();
        $users = $userModel->getAllWithRoles();

        $roleModel = new Role();
        $roles = $roleModel->getAll('id ASC');

        $this->render('admin/users/index', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function create(): void {
        Auth::requirePermission('users', 'create');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $roleId = (int)($_POST['role_id'] ?? 0);
            $phone = trim($_POST['phone'] ?? '');
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            if (empty($name) || empty($email) || empty($password) || $roleId === 0) {
                $this->setFlash('error', 'Por favor complete todos los campos obligatorios.');
                $this->redirect(ADMIN_URL . '/?c=user');
            }

            $userModel = new User();
            if ($userModel->emailExists($email)) {
                $this->setFlash('error', 'El correo electrónico ya está registrado.');
                $this->redirect(ADMIN_URL . '/?c=user');
            }

            $userModel->create([
                'role_id' => $roleId,
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'phone' => $phone,
                'is_active' => $isActive
            ]);

            $this->setFlash('success', 'Usuario creado exitosamente.');
            $this->redirect(ADMIN_URL . '/?c=user');
        }
    }

    public function edit(): void {
        Auth::requirePermission('users', 'edit');

        $id = (int)($_POST['id'] ?? 0);
        $userModel = new User();
        $user = $userModel->find($id);

        if (!$user) {
            $this->setFlash('error', 'Usuario no encontrado.');
            $this->redirect(ADMIN_URL . '/?c=user');
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $roleId = (int)($_POST['role_id'] ?? 0);
        $phone = trim($_POST['phone'] ?? '');
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name) || empty($email) || $roleId === 0) {
            $this->setFlash('error', 'Por favor complete todos los campos obligatorios.');
            $this->redirect(ADMIN_URL . '/?c=user');
        }

        if ($userModel->emailExists($email, $id)) {
            $this->setFlash('error', 'El correo electrónico ya está en uso por otro usuario.');
            $this->redirect(ADMIN_URL . '/?c=user');
        }

        $updateData = [
            'role_id' => $roleId,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'is_active' => $isActive
        ];

        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $userModel->update($id, $updateData);

        $this->setFlash('success', 'Usuario actualizado exitosamente.');
        $this->redirect(ADMIN_URL . '/?c=user');
    }

    public function delete(): void {
        Auth::requirePermission('users', 'delete');

        $id = (int)($_GET['id'] ?? 0);

        if ($id === Auth::id()) {
            $this->setFlash('error', 'No puede eliminar su propia cuenta de usuario.');
            $this->redirect(ADMIN_URL . '/?c=user');
        }

        $userModel = new User();
        $userModel->delete($id);

        $this->setFlash('success', 'Usuario eliminado correctamente.');
        $this->redirect(ADMIN_URL . '/?c=user');
    }

    public function toggle(): void {
        Auth::requirePermission('users', 'edit');

        $id = (int)($_GET['id'] ?? 0);

        if ($id === Auth::id()) {
            $this->setFlash('error', 'No puede desactivar su propia cuenta.');
            $this->redirect(ADMIN_URL . '/?c=user');
        }

        $userModel = new User();
        $user = $userModel->find($id);

        if ($user) {
            $newStatus = $user['is_active'] ? 0 : 1;
            $userModel->update($id, ['is_active' => $newStatus]);
            $this->setFlash('success', 'Estado del usuario actualizado.');
        }

        $this->redirect(ADMIN_URL . '/?c=user');
    }
}
