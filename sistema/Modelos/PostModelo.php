<?php

namespace sistema\Modelos;

use sistema\Nucleo\Conexao;

class PostModelo{

    public function busca(): array
    {
        $query = "SELECT * FROM posts WHERE status = 1";
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

    public function buscaPorId(int $id):bool | array
    {
        $query = "SELECT * FROM posts WHERE id = {$id}";
        $stmt = Conexao::getInstancia()->query($query);
        $result = $stmt->fetch();

        return $result;
    }
}