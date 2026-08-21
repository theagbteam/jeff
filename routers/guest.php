<?php
require_once ROOT_PATH . "/controllers/UserController.php";
$controller = new UserController();
$SearchForMiddleware = new AuthMiddleware();

$action = $_GET['action'] ?? 'login';

switch ($action) {

    case 'login':
        $controller->login();
        break;

    case 'create_reporter':
        $controller->create_reporter();
        break;

    default:
        $controller->pagenotfound();
        break;
}