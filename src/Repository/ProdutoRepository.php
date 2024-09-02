<?php

namespace Victor\AluraPhpExampleSerenatto\Repository;

use Victor\AluraPhpExampleSerenatto\Model\Produto\Produto;
use Victor\AluraPhpExampleSerenatto\Model\Produto\Tipo;

interface ProdutoRepository {
    public function getAllByType(Tipo $tipo): array;
    public function findById(int $id): ?Produto;
    public function create(Produto $produto): Produto;
    public function update(int $id, Produto $produto): ?Produto;
    public function deleteById(int $id): ?Produto;
}
