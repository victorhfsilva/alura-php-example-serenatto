<?php

namespace Victor\AluraPhpExampleSerenatto\Controllers;

use Victor\AluraPhpExampleSerenatto\Repository\Impl\ProdutoRepositoryImpl;

class EditarProdutoController{
    private $repository;

    public function __construct()
    {
        $this->repository = new ProdutoRepositoryImpl();
    }

    public function index()
    {
        $id = $_GET['id'];
        $produto = $this->repository->findById($id);

        // Passa as variáveis para a view
        include_once __DIR__ . '/../View/editar-produto.php';
    }
}

