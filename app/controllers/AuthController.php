<?php
require_once CORE_PATH . 'Controller.php';
require_once MODEL_PATH . 'User.php';

class AuthController extends Controller {
    public function login() {
        if (isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/prompts");
            exit;
        }
        $this->view('auth/login');
    }

    public function loginPost() {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Please fill all fields.';
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $userModel = new User();
        $user = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: " . BASE_URL . "/prompts");
            exit;
        } else {
            $_SESSION['error'] = 'Invalid username or password.';
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . "/login");
        exit;
    }
}
