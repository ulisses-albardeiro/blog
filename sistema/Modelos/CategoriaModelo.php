<?php

namespace sistema\Modelos;
use sistema\Nucleo\Conexao;

class CategoriaModelo{

    public function buscaCategoria(int $id = null): array
    {
        $query = "SELECT * FROM categorias";
        $stmt = Conexao::getInstancia()->query($query);
        $result = $stmt->fetchAll();

        return $result;

    }
}