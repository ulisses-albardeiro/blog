<?php

namespace sistema\Modelos;

use sistema\Nucleo\Conexao;

class PostModelo{

    public function ler(int $id = null): array
    {
        $where = ($id ? "WHERE id = {$id}" : "" );
        $query = "SELECT * FROM posts {$where}";
        $stmt = Conexao::getInstancia()->query($query);
        $result = $stmt->fetchAll();

        return $result;
    }
}