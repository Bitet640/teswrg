<?php
session_start();

// Check if installed
if (!file_exists(__DIR__ . '/../app/config/config.php')) {
    // Use SCRIPT_NAME to derive the correct URL path to install.php to avoid rewrite loops
    $installUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/install.php';
    header('Location: ' . $installUrl);
    exit;
}

require_once __DIR__ . '/../app/config/config.php';

$router = new Router();

// Auth Routes
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@loginPost');
$router->get('/logout', 'AuthController@logout');

// Prompt Routes
$router->get('/prompts', 'PromptController@index');
$router->get('/prompts/create', 'PromptController@create');
$router->post('/prompts/store', 'PromptController@store');
$router->get('/prompts/view', 'PromptController@show'); // using query param ?id=
$router->get('/prompts/edit', 'PromptController@edit'); // using query param ?id=
$router->post('/prompts/update', 'PromptController@update');
$router->get('/prompts/delete', 'PromptController@delete'); // using query param ?id=
$router->get('/prompts/favorite', 'PromptController@toggleFavorite'); // using query param ?id=

// Category Routes
$router->get('/categories', 'CategoryController@index');
$router->get('/categories/edit', 'CategoryController@edit'); // using query param ?id=
$router->post('/categories/store', 'CategoryController@store');
$router->post('/categories/update', 'CategoryController@update');
$router->get('/categories/delete', 'CategoryController@delete'); // using query param ?id=

// Platform Routes
$router->get('/platforms', 'PlatformController@index');
$router->get('/platforms/edit', 'PlatformController@edit'); // using query param ?id=
$router->post('/platforms/store', 'PlatformController@store');
$router->post('/platforms/update', 'PlatformController@update');
$router->get('/platforms/delete', 'PlatformController@delete'); // using query param ?id=

// Default Route
$router->get('/', 'PromptController@index'); // Or login check inside controller

$router->dispatch();
