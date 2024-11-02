<?php
namespace sistema\Controlador\Admin;

use sistema\Modelos\PostModelo;
use sistema\Modelos\CategoriaModelo;
use sistema\Nucleo\Helpers;

class AdminPosts extends AdminControlador
{
    public function listar():void
    {
        $posts = (new PostModelo())->busca();//Busca o titulo e textos do post
        echo $this->template->rendenizar('posts/listar.html', [
            'posts' => $posts, //retorna os dados da tabela posts para a index
        ]);
    }

    public function cadastrarPost():void
    {        
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if(isset($dados)){
            (new PostModelo())->inserirPosts($dados);
            Helpers::redirecionar('admin/posts/listar');
        }

        //lista no select as categorias
        $categorias = (new CategoriaModelo())->busca();
        echo $this->template->rendenizar('posts/cadastrar.html', [
            'categorias' => $categorias
        ]);
    }

    public function editarPost(int $id)
    {
        $post = (new PostModelo())->buscaPorIdPost($id);

        if(!$post){
            Helpers::redirecionar('404');
        }
        echo $this->template->rendenizar('posts/cadastrar.html', [
            'post' => $post
        ]);

    }

}