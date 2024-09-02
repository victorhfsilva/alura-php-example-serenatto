<?php

namespace Victor\AluraPhpExampleSerenatto\Repository\Impl;

use Victor\AluraPhpExampleSerenatto\Model\Produto\Produto;
use Victor\AluraPhpExampleSerenatto\Model\Produto\Tipo;
use Victor\AluraPhpExampleSerenatto\Repository\ProdutoRepository;
use Victor\AluraPhpExampleSerenatto\Config\DbConnection;
use PDO;
use PDOException;

class ProdutoRepositoryImpl implements ProdutoRepository {
    private $db;

    public function __construct() {
        $dbConnection = new DbConnection();
        $this->db = $dbConnection->getPdo();
    }

    public function getAllByType(Tipo $tipo = null): array {
        if (is_null($tipo)) {
            $sql = 'SELECT * FROM produtos;';
            $stmt = $this->db->prepare($sql);
        } else {
            $sql = 'SELECT * FROM produtos WHERE tipo = :tipo';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':tipo', $tipo->value);
        }
        
        $stmt->execute();

        $produtosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $produtos = [];
        foreach ($produtosData as $produtoData) {
            $produtos[] = new Produto(
                $produtoData['nome'],
                Tipo::from($produtoData['tipo']),
                $produtoData['descricao'],
                (float) $produtoData['preco'],
                $produtoData['imagem'],
                (int) $produtoData['id']
            );
        }

        return $produtos;
    }

    public function findById(int $id): ?Produto {
        $stmt = $this->db->prepare('SELECT * FROM produtos WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $produtoData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produtoData) {
            return new Produto(
                $produtoData['nome'],
                Tipo::from($produtoData['tipo']),
                $produtoData['descricao'],
                (float) $produtoData['preco'],
                $produtoData['imagem'],
                (int) $produtoData['id']
            );
        }

        return null;
    }

    public function create(Produto $produto): Produto {
        $stmt = $this->db->prepare('INSERT INTO produtos (tipo, nome, descricao, imagem, preco) VALUES (:tipo, :nome, :descricao, :imagem, :preco)');
        $stmt->bindValue(':tipo', $produto->getTipo()->value);
        $stmt->bindValue(':nome', $produto->getNome());
        $stmt->bindValue(':descricao', $produto->getDescricao());
        $stmt->bindValue(':imagem', $produto->getImagem());
        $stmt->bindValue(':preco', $produto->getPreco());

        $stmt->execute();
        $produto->setId((int)$this->db->lastInsertId());
        
        return $produto;
    }

    public function update(int $id, Produto $produto): ?Produto {
        $produto_salvo = $this->findById($id);
        if ($produto_salvo === null) {
            // Produto não encontrado, não pode ser excluído
            return null;
        }
        
        $stmt = $this->db->prepare('UPDATE produtos SET tipo = :tipo, nome = :nome, descricao = :descricao, imagem = :imagem, preco = :preco WHERE id = :id');
        $stmt->bindValue(':tipo', $produto->getTipo()->value);
        $stmt->bindValue(':nome', $produto->getNome());
        $stmt->bindValue(':descricao', $produto->getDescricao());
        $stmt->bindValue(':imagem', $produto->getImagem());
        $stmt->bindValue(':preco', $produto->getPreco());
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        $produto->setId((int) $id);

        return $produto;
    }

    public function deleteById(int $id): ?Produto {
        $produto = $this->findById($id);
        if ($produto === null) {
            // Produto não encontrado, não pode ser excluído
            return null;
        }

        $stmt = $this->db->prepare('DELETE FROM produtos WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();

        return $produto;
    }
}

