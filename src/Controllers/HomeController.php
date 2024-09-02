<?php

    namespace Victor\AluraPhpExampleSerenatto\Controllers;

    use Victor\AluraPhpExampleSerenatto\Model\Produto\Tipo;
    use Victor\AluraPhpExampleSerenatto\Repository\Impl\ProdutoRepositoryImpl;

    class HomeController{
        private $repository;

        public function __construct()
        {
            $this->repository = new ProdutoRepositoryImpl();
        }
    
        public function index()
        {
            $cafes = $this->repository->getAllByType(Tipo::CAFE);
            $almocos = $this->repository->getAllByType(Tipo::ALMOCO);
    
            // Passa as variáveis para a view
            include_once __DIR__ . '/../View/index.php';
        }
    }



