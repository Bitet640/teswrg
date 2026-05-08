<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'prompt_management');

// Auto-detect Base URL for portability
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$root = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
$root = str_replace('/public', '', $root); // Ensure public is removed from Base URL
define('BASE_URL', $protocol . '://' . $host . $root);
define('APP_NAME', 'PromptManager');

define('CONTROLLER_PATH', __DIR__ . '/../controllers/');
define('VIEW_PATH', __DIR__ . '/../views/');
define('MODEL_PATH', __DIR__ . '/../models/');
define('CORE_PATH', __DIR__ . '/../core/');

require_once CORE_PATH . 'Database.php';
require_once CORE_PATH . 'Controller.php';
require_once CORE_PATH . 'Model.php';
require_once CORE_PATH . 'Router.php';

// Autoload helper if needed
function redirect($path) {
    header("Location: " . BASE_URL . $path);
    exit;
}

function view($path, $data = []) {
    extract($data);
    require_once VIEW_PATH . $path . '.php';
}

function public_url($path) {
    return BASE_URL . '/public/' . ltrim($path, '/');
}
