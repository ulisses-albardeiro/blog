<?php

namespace sistema\Modelos;
use sistema\Nucleo\Conexao;

class CategoriaModelo{

    public function buscaCategoria(): array
    {
        $query = "SELECT * FROM categorias";
        $stmt = Conexao::getInstancia()->query($query);
        $result = $stmt->fetchAll();

        return $result;

    }

    public function posts(int $id ): array
    {
        $query = "SELECT * FROM posts WHERE categoria_id = {$id} AND status = 1";
        $stmt = Conexao::getInstancia()->query($query);
        $result = $stmt->fetchAll();

        return $result;

    }

    public function inserirCategoria(array $dados):void 
    {
        $query = "INSERT INTO categorias (titulo, descricao, status) VALUES (?, ?, ?)";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['titulo'], $dados['descricao'], $dados['status']]);
    }

    public function buscaPorIdCategoria(int $id):bool | array
    {
        $query = "SELECT * FROM categorias WHERE id = {$id}";
        $stmt = Conexao::getInstancia()->query($query);
        $result = $stmt->fetch();

        return $result;
    }

    public function atualizarCategoria(int $id, array $dados): void
    {
        $query = "UPDATE categorias SET titulo = ?, descricao = ?, status = ? WHERE id = ?";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['titulo'], $dados['descricao'], $dados['status'], $id]);
    }

    public function deletarCategoria(int $id): void
    {
        $query = "DELETE FROM categorias WHERE id = ?";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$id]);
    }
}