<?php

namespace sistema\Modelos;
use sistema\Nucleo\Conexao;

class CategoriaModelo{

    public function busca(): array
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
}