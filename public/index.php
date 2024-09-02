<?php

require_once '../vendor/autoload.php';

use Victor\AluraPhpExampleSerenatto\Controllers\AdminController;
use Victor\AluraPhpExampleSerenatto\Controllers\HomeController;
use Victor\AluraPhpExampleSerenatto\Controllers\ProdutoController;
use Victor\AluraPhpExampleSerenatto\Controllers\CadastrarProdutoController;
use Victor\AluraPhpExampleSerenatto\Controllers\EditarProdutoController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($uri) {
    case '/':
        $controller = new HomeController();
        $controller->index();
        break;

    case '/admin':
        $controller = new AdminController();
        $controller->index();
        break;

    case '/excluir-produto':
        $controller = new ProdutoController();
        $controller->delete();
        break;

    case '/cadastrar-produto':
        if ($method == 'GET'){
            $controller = new CadastrarProdutoController();
            $controller->index();
        } elseif ($method == 'POST') {
            $controller = new ProdutoController();
            $controller->create();
        }
        break;

    case '/editar-produto':
        if ($method == 'GET'){
            $controller = new EditarProdutoController();
            $controller->index();
        } elseif ($method == 'POST') {
            $controller = new ProdutoController();
            $controller->update();
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['message' => 'Resource not found']);
        break;
}
