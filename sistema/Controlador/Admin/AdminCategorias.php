<?php
namespace sistema\Controlador\Admin;

use sistema\Modelos\CategoriaModelo;
use sistema\Nucleo\Helpers;


class AdminCategorias extends AdminControlador
{
    public function listar():void
    {
        $categorias = (new CategoriaModelo())->busca();
        echo $this->template->rendenizar('categorias/listar.html', [
            'categorias' => $categorias, 
        ]);
    }

    public function cadastrarCategoria():void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if(isset($dados)){
            (new CategoriaModelo)->inserirCategoria($dados);
            Helpers::redirecionar("admin/categorias/listar");
        }
       
        echo $this->template->rendenizar('categorias/cadastrar.html', []);
    }

    public function editarCategoria(int $id):void
    {
        $categoria =(new CategoriaModelo())->buscaPorIdCategoria($id);


        echo $this->template->rendenizar('categorias/cadastrar.html', [
            'categoria' => $categoria
        ]);
    }
}