<?php

namespace sistema\Modelos;

use sistema\Nucleo\Conexao;

class PostModelo
{

    public function buscaPosts(): array
    {
        $query = "SELECT * FROM posts";
        $stmt = Conexao::getInstancia()->query($query);
        $result = $stmt->fetchAll();

        return $result;
    }

    public function pesquisa($pesquisa)
    {
        $query = "SELECT * FROM posts WHERE status = 1 AND titulo LIKE '%{$pesquisa}%'";
        $stmt = Conexao::getInstancia()->query($query);
        $result = $stmt->fetchAll();

        return $result;
    }

    public function buscaPorIdPost(int $id): bool | array
    {
        $query = "SELECT * FROM posts WHERE id = {$id}";
        $stmt = Conexao::getInstancia()->query($query);
        $result = $stmt->fetch();

        return $result;
    }

    public function inserirPosts(array $dados): void
    {
        $query = "INSERT INTO posts (titulo, texto, categoria_id, status) VALUES (?, ?, ?, ?)";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['titulo'], $dados['texto'], $dados['categoria_id'], $dados['status']]);
    }

    public function atualizarPost(int $id, array $dados): void
    {
        $query = "UPDATE posts SET titulo = ?, texto = ?, categoria_id = ?, status = ? WHERE id = ?";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['titulo'], $dados['texto'], $dados['categoria_id'], $dados['status'], $id]);
    }

    public function deletarPost(int $id): void
    {
        $query = "DELETE FROM posts WHERE id = ?";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$id]);
    }
}
