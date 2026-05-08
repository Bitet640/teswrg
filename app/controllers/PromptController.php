<?php
require_once CORE_PATH . 'Controller.php';
require_once MODEL_PATH . 'Prompt.php';
require_once MODEL_PATH . 'Category.php';
require_once MODEL_PATH . 'Platform.php';

class PromptController extends Controller {

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
        $promptModel = new Prompt();
        $categoryModel = new Category();

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $search = $_GET['search'] ?? '';
        $filters = [
            'category_id' => $_GET['category_id'] ?? '',
            'type' => $_GET['type'] ?? ''
        ];

        $totalPrompts = $promptModel->countAll($filters, $search);
        $totalPages = ceil($totalPrompts / $limit);

        $prompts = $promptModel->getAll($filters, $search, $limit, $offset);
        


        $categories = $categoryModel->getAll();

        $this->view('prompts/index', [
            'prompts' => $prompts,
            'categories' => $categories,
            'search' => $search,
            'filters' => $filters,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalPrompts' => $totalPrompts
            ]
        ]);
    }

    public function create() {
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();
        
        $platformModel = new Platform();
        $platforms = $platformModel->getAll();
        
        $this->view('prompts/create', [
            'categories' => $categories, 
            'platforms' => $platforms
        ]);
    }

    public function store() {
        $promptModel = new Prompt();
        
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = __DIR__ . '/../../public/uploads/prompts/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            // Generate unique name
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('prompt_') . '.' . $extension;
            $targetPath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = 'uploads/prompts/' . $filename;
            }
        }

        $data = [
            'user_id' => $_SESSION['user_id'],
            'category_id' => $_POST['category_id'],
            'title' => $_POST['title'],
            // 'description' => $_POST['description'],
            'content' => $_POST['content'],
            'platform' => $_POST['platform'],
            'type' => $_POST['type'],
            'status' => 'Published', // Default for now
            'image_path' => $imagePath
        ];

        // Basic validation could be added here
        
        $promptModel->create($data); 
        // Note: Not handling tags saving right now for brevity, 
        // would require lastInsertId and separate tag table logic.

        header("Location: " . BASE_URL . "/prompts");
    }

    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: " . BASE_URL . "/prompts");
            exit;
        }

        $promptModel = new Prompt();
        $prompt = $promptModel->find($id);
        
        $this->view('prompts/show', ['prompt' => $prompt]);
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: " . BASE_URL . "/prompts");
            exit;
        }
        
        $promptModel = new Prompt();
        $categoryModel = new Category();
        $platformModel = new Platform();
        
        $prompt = $promptModel->find($id);
        $categories = $categoryModel->getAll();
        $platforms = $platformModel->getAll();

        $this->view('prompts/edit', [
            'prompt' => $prompt, 
            'categories' => $categories,
            'platforms' => $platforms
        ]);
    }
    
    public function update() {
        $id = $_POST['id'];
        $promptModel = new Prompt();
        
        $data = [
            'category_id' => $_POST['category_id'],
            'title' => $_POST['title'],
            // 'description' => $_POST['description'],
            'content' => $_POST['content'],
            'platform' => $_POST['platform'],
            'type' => $_POST['type'],
            'status' => $_POST['status']
        ];
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = __DIR__ . '/../../public/uploads/prompts/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('prompt_') . '.' . $extension;
            $targetPath = $uploadDir . $filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $data['image_path'] = 'uploads/prompts/' . $filename;
            }
        }
        
        $promptModel->update($id, $data);
        header("Location: " . BASE_URL . "/prompts");
    }

    public function delete() {
        $id = $_GET['id'];
        $promptModel = new Prompt();
        $promptModel->delete($id);
        header("Location: " . BASE_URL . "/prompts");
    }

    public function toggleFavorite() {
        $id = $_GET['id'];
        $promptModel = new Prompt();
        $promptModel->toggleFavorite($id);
        header("Location: " . BASE_URL . "/prompts");
    }
}
