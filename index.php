<?php
// vet_burgos/index.php

require_once 'config/database.php';

// Sistema de enrutamiento estándar
$controller_name = isset($_GET['controller']) ? $_GET['controller'] : 'Home';
$action_name = isset($_GET['action']) ? $_GET['action'] : 'index';

$controller_file = 'controllers/' . $controller_name . 'Controller.php';

if (file_exists($controller_file)) {
    require_once $controller_file;

    $controller_class = $controller_name . 'Controller';
    $controller = new $controller_class();

    if (method_exists($controller, $action_name)) {
        $controller->$action_name();
    } else {
        echo "Error: La acción '$action_name' no existe en el controlador '$controller_name'.";
    }
} else {
    echo "Error: El controlador '$controller_name' no existe.";
}
