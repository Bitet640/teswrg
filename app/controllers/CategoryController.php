<?php
require_once CORE_PATH . 'Controller.php';
require_once MODEL_PATH . 'Category.php';

class CategoryController extends Controller {
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
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();
        $this->view('categories/index', ['categories' => $categories]);
    }

    public function store() {
        $categoryModel = new Category();
        $categoryModel->create(['name' => $_POST['name'], 'color' => $_POST['color']]);
        header("Location: " . BASE_URL . "/categories");
        exit;
    }

    public function edit() {
        $id = $_GET['id'];
        $categoryModel = new Category();
        $category = $categoryModel->find($id);
        $this->view('categories/edit', ['category' => $category]);
    }

    public function update() {
        $id = $_POST['id'];
        $categoryModel = new Category();
        $categoryModel->update($id, ['name' => $_POST['name'], 'color' => $_POST['color']]);
        header("Location: " . BASE_URL . "/categories");
        exit;
    }

    public function delete() {
        $id = $_GET['id'];
        $categoryModel = new Category();
        $categoryModel->delete($id);
        header("Location: " . BASE_URL . "/categories");
        exit;
    }
}
