<?php

namespace Victor\AluraPhpExampleSerenatto\Controllers;

use Victor\AluraPhpExampleSerenatto\Repository\Impl\ProdutoRepositoryImpl;

class AdminController {
    private $repository;

    public function __construct()
    {
        $this->repository = new ProdutoRepositoryImpl();
    }

    public function index()
    {
        $produtos = $this->repository->getAllByType();

        include_once __DIR__ . '/../View/admin.php';
    }
}

