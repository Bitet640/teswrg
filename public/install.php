<?php
// Function to check if app is already installed
if (file_exists(__DIR__ . '/../app/config/config.php') && (!isset($_GET['mode']) || $_GET['mode'] !== 'reconfigure')) {
    header('Location: index.php');
    exit;
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host = 'localhost'; // Default, maybe add input for this too if needed, but user didn't ask
    $db_user = $_POST['db_user'] ?? '';
    $db_pass = $_POST['db_pass'] ?? '';
    $db_name = $_POST['db_name'] ?? '';
    $base_url = rtrim($_POST['base_url'] ?? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]" . str_replace(['/install.php', '/public'], '', $_SERVER['SCRIPT_NAME']), '/');

    // Basic validation
    if (empty($db_user) || empty($db_name) || empty($base_url)) {
        $error = 'Please fill in all required fields.';
    } else {
        // Try to connect to database
        try {
            // First connect without DB to check connection
            $dsn_no_db = "mysql:host=$db_host;charset=utf8mb4";
            $pdo = new PDO($dsn_no_db, $db_user, $db_pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Check if DB exists, if not try to create (optional, but good for local)
            // But hosting usually requires existing DB. We'll try to select it.
            try {
                $pdo->exec("USE `$db_name`");
            } catch (PDOException $e) {
                // If DB doesn't exist, try to create it
                $pdo->exec("CREATE DATABASE `$db_name`");
                $pdo->exec("USE `$db_name`");
            }

            // Create Tables directly via PHP code
            $queries = [
                "CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

                "CREATE TABLE IF NOT EXISTS categories (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(50) NOT NULL,
                    color VARCHAR(20) DEFAULT 'blue',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

                "CREATE TABLE IF NOT EXISTS prompts (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT NOT NULL,
                    category_id INT,
                    title VARCHAR(255) NOT NULL,
                    content TEXT NOT NULL,
                    platform VARCHAR(50) DEFAULT 'chatgpt',
                    type VARCHAR(50) DEFAULT 'text',
                    status VARCHAR(20) DEFAULT 'draft',
                    image_path VARCHAR(255),
                    is_favorite TINYINT(1) DEFAULT 0,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
                
                "CREATE TABLE IF NOT EXISTS platforms (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(50) NOT NULL UNIQUE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

                // Insert default user if not exists
                "INSERT IGNORE INTO users (username, password) VALUES ('admin', '" . password_hash('password', PASSWORD_DEFAULT) . "');",
                
                // Insert default categories
                "INSERT IGNORE INTO categories (name, color) VALUES 
                ('Writing', 'blue'),
                ('Coding', 'green'),
                ('Marketing', 'purple'),
                ('SEO', 'orange'),
                ('Business', 'gray');",

                // Insert default platforms
                "INSERT IGNORE INTO platforms (name) VALUES 
                ('ChatGPT'),
                ('Gemini'),
                ('Midjourney'),
                ('Claude'),
                ('Stable Diffusion'),
                ('DALL-E'),
                ('Jasper'),
                ('Other');"
            ];

            foreach ($queries as $query) {
                $pdo->exec($query);
            }

            if (empty($error)) {
                // Create config file
                $configContent = "<?php
define('DB_HOST', '$db_host');
define('DB_USER', '$db_user');
define('DB_PASS', '$db_pass');
define('DB_NAME', '$db_name');

// Auto-detect Base URL for portability
\$protocol = isset(\$_SERVER['HTTPS']) && \$_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
\$host = \$_SERVER['HTTP_HOST'] ?? 'localhost';
\$root = str_replace('/index.php', '', \$_SERVER['SCRIPT_NAME']);
\$root = str_replace('/public', '', \$root); // Remove public from Base URL
define('BASE_URL', \$protocol . '://' . \$host . \$root);
define('APP_NAME', 'PromptManager');

define('CONTROLLER_PATH', __DIR__ . '/../controllers/');
define('VIEW_PATH', __DIR__ . '/../views/');
define('MODEL_PATH', __DIR__ . '/../models/');
define('CORE_PATH', __DIR__ . '/../core/');

require_once CORE_PATH . 'Database.php';
require_once CORE_PATH . 'Controller.php';
require_once CORE_PATH . 'Model.php';
require_once CORE_PATH . 'Router.php';

function redirect(\$path) {
    header(\"Location: \" . BASE_URL . \$path);
    exit;
}

function view(\$path, \$data = []) {
    extract(\$data);
    require_once VIEW_PATH . \$path . '.php';
}

function public_url(\$path) {
    return BASE_URL . '/public/' . ltrim(\$path, '/');
}
";
                // Ensure directory exists
                if (!is_dir(__DIR__ . '/../app/config')) {
                    mkdir(__DIR__ . '/../app/config', 0755, true);
                }
                
                if (file_put_contents(__DIR__ . '/../app/config/config.php', $configContent)) {
                    $message = "Installation successful! Redirecting to login...";
                    // Meta refresh to redirect to /login using absolute URL
                    echo '<meta http-equiv="refresh" content="2;url=' . $base_url . '/login">';
                } else {
                    $error = "Failed to write config file. Check permissions.";
                }
            }

        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install PromptManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 flex items-center justify-center min-h-screen p-4">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm"></div>

    <div class="relative w-full max-w-xl bg-slate-800/50 border border-slate-700 p-8 rounded-2xl shadow-2xl">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500 mb-2">PromptManager</h1>
            <p class="text-slate-400">Application Installer</p>
        </div>

        <?php if ($message): ?>
            <div class="bg-green-500/10 border border-green-500/50 text-green-400 p-4 rounded-lg mb-6 text-center">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-lg mb-6 text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Database Host</label>
                <input type="text" value="localhost" disabled class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-2 text-slate-400 cursor-not-allowed">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Database Name</label>
                <input type="text" name="db_name" required placeholder="db_name" value="<?= htmlspecialchars($_POST['db_name'] ?? '') ?>" class="w-full bg-slate-900/50 border border-slate-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500 transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">DB User</label>
                    <input type="text" name="db_user" required placeholder="root" value="<?= htmlspecialchars($_POST['db_user'] ?? '') ?>" class="w-full bg-slate-900/50 border border-slate-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">DB Password</label>
                    <input type="password" name="db_pass" placeholder="******" class="w-full bg-slate-900/50 border border-slate-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Base URL</label>
                <input type="url" name="base_url" required placeholder="http://yourdomain.com" value="<?= htmlspecialchars($_POST['base_url'] ?? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]" . str_replace(['/install.php', '/public'], '', $_SERVER['SCRIPT_NAME'])) ?>" class="w-full bg-slate-900/50 border border-slate-600 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-blue-500 transition">
                <p class="text-xs text-slate-500 mt-1">Pastikan URL ini sesuai dengan URL yang diakses</p>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-bold py-3 rounded-lg shadow-lg hover:shadow-blue-500/25 transition duration-300 transform hover:-translate-y-0.5">
                Install & Continue
            </button>
        </form>
    </div>
</body>
</html>
