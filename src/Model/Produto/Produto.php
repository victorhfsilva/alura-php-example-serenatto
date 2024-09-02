<?php

namespace Victor\AluraPhpExampleSerenatto\Model\Produto;

class Produto {
    private ?int $id;

    private string $nome;

    private Tipo $tipo;

    private string $descricao;

    private float $preco;

    private string $imagem;
    //Imagem

    public function __construct(string $nome, Tipo $tipo, string $descricao, float $preco, string $imagem = "logo-serenatto.png", int $id = null) {
        $this->id = $id;
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->imagem = $imagem;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getTipo(): Tipo {
        return $this->tipo;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }

    public function getPreco(): float {
        return $this->preco;
    }

    public function getPrecoFormatado(): string {
        return number_format($this->preco, 2, ',', '.');
    }

    public function getImagem(): string {
        return $this->imagem;
    }

    public function getImagemDir(): string {
        return "/img/" . $this->imagem;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setImagem(string $imagem): void {
        $this->imagem = $imagem;
    }
}
