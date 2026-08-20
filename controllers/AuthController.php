<?php
/**
 * Controlador de Autenticación
 */

class AuthController extends Controller {

    public function login(): void {
        if (Auth::check()) {
            $this->redirect(ADMIN_URL . '/?c=dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $this->setFlash('error', 'Por favor complete todos los campos.');
                $this->render('admin/auth/login', ['email' => $email], 'auth');
                return;
            }

            $userModel = new User();
            $user = $userModel->authenticate($email, $password);

            if ($user) {
                Auth::login($user);
                $this->setFlash('success', '¡Bienvenido, ' . htmlspecialchars($user['name']) . '!');
                $this->redirect(ADMIN_URL . '/?c=dashboard');
            } else {
                $this->setFlash('error', 'Credenciales incorrectas o usuario inactivo.');
                $this->render('admin/auth/login', ['email' => $email], 'auth');
                return;
            }
        }

        $this->render('admin/auth/login', [], 'auth');
    }

    public function logout(): void {
        Auth::logout();
        $this->redirect(ADMIN_URL . '/?c=auth&a=login');
    }

    public function profile(): void {
        Auth::requireAuth();
        $userModel = new User();
        $user = $userModel->findWithRole(Auth::id());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($name)) {
                $this->setFlash('error', 'El nombre no puede estar vacío.');
                $this->render('admin/auth/profile', ['user' => $user]);
                return;
            }

            $updateData = [
                'name' => $name,
                'phone' => $phone
            ];

            // Si desea cambiar contraseña
            if (!empty($newPassword)) {
                if (empty($currentPassword)) {
                    $this->setFlash('error', 'Debe ingresar su contraseña actual para cambiarla.');
                    $this->render('admin/auth/profile', ['user' => $user]);
                    return;
                }

                if (!password_verify($currentPassword, $user['password'])) {
                    $this->setFlash('error', 'La contraseña actual es incorrecta.');
                    $this->render('admin/auth/profile', ['user' => $user]);
                    return;
                }

                if (strlen($newPassword) < 6) {
                    $this->setFlash('error', 'La nueva contraseña debe tener al menos 6 caracteres.');
                    $this->render('admin/auth/profile', ['user' => $user]);
                    return;
                }

                if ($newPassword !== $confirmPassword) {
                    $this->setFlash('error', 'Las nuevas contraseñas no coinciden.');
                    $this->render('admin/auth/profile', ['user' => $user]);
                    return;
                }

                $updateData['password'] = password_hash($newPassword, PASSWORD_BCRYPT);
            }

            $userModel->update(Auth::id(), $updateData);
            $_SESSION['user_name'] = $name;
            $_SESSION['user_phone'] = $phone;

            $this->setFlash('success', 'Perfil actualizado exitosamente.');
            $this->redirect(ADMIN_URL . '/?c=auth&a=profile');
        }

        $this->render('admin/auth/profile', ['user' => $user]);
    }
}
