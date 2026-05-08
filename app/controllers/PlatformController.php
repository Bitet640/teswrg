<?php
require_once CORE_PATH . 'Controller.php';
require_once MODEL_PATH . 'Platform.php';

class PlatformController extends Controller {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public function index() {
        $platformModel = new Platform();
        $platforms = $platformModel->getAll();
        $this->view('platforms/index', ['platforms' => $platforms]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            if (!empty($name)) {
                $platformModel = new Platform();
                $platformModel->create(['name' => $name]);
            }
            header("Location: " . BASE_URL . "/platforms");
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: " . BASE_URL . "/platforms");
            exit;
        }

        $platformModel = new Platform();
        $platform = $platformModel->find($id);
        
        // Passing all platforms too, in case we want to show list below form or something, 
        // but for now just the edit view usually needs the item being edited.
        // However, user might want a separate edit page or inline edit.
        // I will create a dedicated edit page similar to categories if it exists, or update index.
        // Let's check CategoryController structure.
        
        $this->view('platforms/edit', ['platform' => $platform]);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = trim($_POST['name']);
            
            if (!empty($id) && !empty($name)) {
                $platformModel = new Platform();
                $platformModel->update($id, ['name' => $name]);
            }
            header("Location: " . BASE_URL . "/platforms");
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $platformModel = new Platform();
            $platformModel->delete($id);
        }
        header("Location: " . BASE_URL . "/platforms");
    }
}
