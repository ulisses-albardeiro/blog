<?php

namespace sistema\Modelos;

use sistema\Nucleo\Conexao;

class PostModelo{

    public function busca(int $id = null): array
    {
        $query = "SELECT * FROM posts";
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