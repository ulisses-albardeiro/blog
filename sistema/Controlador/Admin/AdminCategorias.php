<?php

namespace sistema\Controlador\Admin;

use sistema\Modelos\CategoriaModelo;
use sistema\Nucleo\Helpers;


class AdminCategorias extends AdminControlador
{
    public function listar(): void
    {
        $categorias = (new CategoriaModelo())->busca()->resultado(true);
        echo $this->template->rendenizar('categorias/listar.html', [
            'categorias' => $categorias,
        ]);
    }

    public function cadastrarCategoria(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($dados)) {
            $categoria = new CategoriaModelo;
            $categoria->titulo = $dados['titulo'];
            $categoria->descricao = $dados['descricao'];
            $categoria->status = $dados['status'];
            $categoria->slug = Helpers::slug($dados['titulo']);

            if ($categoria->salvar()) {
                $this->mensagem->mensagemSucesso('Categoria cadastrada com sucesso')->flash();
                Helpers::redirecionar('admin/categorias/listar');
            }
        }

        echo $this->template->rendenizar('categorias/cadastrar.html', []);
    }

    public function editarCategoria(int $id): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (isset($dados)) {
            $categoria = new CategoriaModelo;
            $categoria->id = $id;
            $categoria->titulo = $dados['titulo'];
            $categoria->descricao = $dados['descricao'];
            $categoria->status = $dados['status'];
            $categoria->slug = Helpers::slug($dados['titulo']);


            if ($categoria->salvar()) {
                $this->mensagem->mensagemSucesso('Categoria editada com sucesso')->flash();
                Helpers::redirecionar('admin/categorias/listar');
            }
        }

        $categoria = (new CategoriaModelo())->busca('id = :id', 'id=' .$id)->resultado();
        echo $this->template->rendenizar('categorias/cadastrar.html', [
            'categoria' => $categoria
        ]);
    }

    public function excluirCategoria(int $id): void
    {
        if (is_int($id)) {
            $categoria = (new CategoriaModelo())->buscaPorId($id);
            if (!$categoria) {
                $this->mensagem->mensagemErro("Não foi possivel Realizar essa operação")->flash();
                Helpers::redirecionar("admin/categorias/listar");
            } else {
                if ($categoria->apagar("id = {$id}")) {
                    $this->mensagem->mensagemSucesso("Categoria deletada com sucesso!")->flash();
                    Helpers::redirecionar("admin/categorias/listar");
                }else{
                    $this->mensagem->mensagemErro("Houve um erro inesperado")->flash();
                    Helpers::redirecionar("admin/categorias/listar");
                }
            }
        }

    }
}
