<?php

namespace Victor\AluraPhpExampleSerenatto\Controllers;

use Victor\AluraPhpExampleSerenatto\Repository\Impl\ProdutoRepositoryImpl;
use Victor\AluraPhpExampleSerenatto\Model\Produto\Produto;
use Victor\AluraPhpExampleSerenatto\Model\Produto\Tipo;
use Dompdf\Dompdf;

class ProdutoController{
    private $repository;

    public function __construct()
    {
        $this->repository = new ProdutoRepositoryImpl();
    }

    public function delete()
    {
        $id = (int) $_POST['id'];

        $this->repository->deleteById($id);
        
        header("Location: admin");
    }

    public function create()
    {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = (float) $_POST['preco'];

        switch ($_POST['tipo'] ) {
            case 'Almoço':
                $tipo = Tipo::ALMOCO;
                break;
            case 'Café':
                $tipo = Tipo::CAFE;
                break;
        }

        $produto = new Produto( $nome, $tipo, $descricao, $preco );

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $imagem = uniqid() . '_' . basename($_FILES['imagem']['name']);
            $imagemTmp = $_FILES['imagem']['tmp_name'];
            
            $uploadDir = __DIR__ . '/../../public/img/';
            $uploadFile = $uploadDir . $imagem;
        
            if (move_uploaded_file($imagemTmp, $uploadFile)) {
                $produto->setImagem($imagem);
            } else {
                throw new \Exception("Falha ao mover o arquivo de imagem.");
            }
        }
        $this->repository->create($produto);

        header("Location: admin");
    }

    public function update()
    {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = (float) $_POST['preco'];

        switch ($_POST['tipo'] ) {
            case 'Almoço':
                $tipo = Tipo::ALMOCO;
                break;
            case 'Café':
                $tipo = Tipo::CAFE;
                break;
        }

        $produto = new Produto( $nome, $tipo, $descricao, $preco);

        $produtoExistente = $this->repository->findById($id);
        if (!$produtoExistente) {
            throw new \Exception("Produto não encontrado.");
        }
    
        $imagem = $produtoExistente->getImagem();
        $produto->setImagem($imagem);

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $imagem = uniqid() . '_' . basename($_FILES['imagem']['name']);
            $imagemTmp = $_FILES['imagem']['tmp_name'];
            
            $uploadDir = __DIR__ . '/../../public/img/';
            $uploadFile = $uploadDir . $imagem;
        
            if (move_uploaded_file($imagemTmp, $uploadFile)) {
                $produto->setImagem($imagem);
            } else {
                throw new \Exception("Falha ao mover o arquivo de imagem.");
            }
        }

        $this->repository->update($id, $produto);

        header("Location: admin");
    }

}


