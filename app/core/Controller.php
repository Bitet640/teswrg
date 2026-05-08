<?php

class Controller {
    public function view($view, $data = []) {
        extract($data);
        require_once VIEW_PATH . $view . '.php';
    }

    public function redirect($path) {
        header("Location: " . BASE_URL . $path);
        exit;
    }
}
