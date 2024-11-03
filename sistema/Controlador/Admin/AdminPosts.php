<?php
namespace sistema\Controlador\Admin;

use sistema\Modelos\PostModelo;
use sistema\Modelos\CategoriaModelo;
use sistema\Nucleo\Helpers;

class AdminPosts extends AdminControlador
{
    public function listar():void
    {
        $posts = (new PostModelo())->buscaPosts();//Busca o titulo e textos do post
        echo $this->template->rendenizar('posts/listar.html', [
            'posts' => $posts
        ]);
    }

    public function cadastrarPost():void
    {        
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if(isset($dados)){
            (new PostModelo())->inserirPosts($dados);
            $this->mensagem->mensagemSucesso('Post cadastrado com sucesso')->flash();
            Helpers::redirecionar('admin/posts/listar');
        }

        //lista no select as categorias
        $categorias = (new CategoriaModelo())->buscaCategoria();
        echo $this->template->rendenizar('posts/cadastrar.html', [
            'categorias' => $categorias
        ]);

    }


    public function editarPost(int $id)
    {

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if(isset($dados)){
            (new PostModelo())->atualizarPost($id, $dados);
            $this->mensagem->mensagemSucesso('Post editado com sucesso')->flash();
            Helpers::redirecionar("admin/posts/listar");
        }


        $post = (new PostModelo())->buscaPorIdPost($id); //Lista od dados do post na edição
        $categorias = (new CategoriaModelo())->buscaCategoria(); //Lista os dados das categorias na edição
        echo $this->template->rendenizar('posts/cadastrar.html', [
            'post' => $post,
            'categorias' => $categorias
        ]);

    }

    public function excluirPost(int $id):void
    {
        (new PostModelo())->deletarPost($id);
            Helpers::redirecionar("admin/posts/listar");
    }

}