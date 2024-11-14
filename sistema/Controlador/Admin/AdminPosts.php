<?php

namespace sistema\Controlador\Admin;

use sistema\Modelos\PostModelo;
use sistema\Modelos\CategoriaModelo;
use sistema\Nucleo\Helpers;

class AdminPosts extends AdminControlador
{
    public function listar(): void
    {
        $posts = (new PostModelo())->busca()->ordem('id DESC')->resultado(true); //Busca o titulo e textos do post
        echo $this->template->rendenizar('posts/listar.html', [
            'posts' => $posts,
        ]);
    }

    public function cadastrarPost(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($dados)) {
            $post = new PostModelo;
            $post->titulo = $dados['titulo'];
            $post->categoria_id = $dados['categoria_id'];
            $post->texto = $dados['texto'];
            $post->status = $dados['status'];

            if ($post->salvar()) {
                $this->mensagem->mensagemSucesso('Post cadastrado com sucesso')->flash();
                Helpers::redirecionar('admin/posts/listar');
            }
        }

        //lista no select as categorias
        $categorias = (new CategoriaModelo())->buscaCategoria();
        echo $this->template->rendenizar('posts/cadastrar.html', [
            'categorias' => $categorias
        ]);
    }


    public function editarPost(int $id)
    {
        $post = (new PostModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            //(new PostModelo())->atualizarPost($id, $dados);
            $post = (new PostModelo())->buscaPorId($id);
            $post->titulo = $dados['titulo'];
            $post->categoria_id = $dados['categoria_id'];
            $post->texto = $dados['texto'];
            $post->status = $dados['status'];

            if ($post->salvar()) {
                $this->mensagem->mensagemSucesso('Post editado com sucesso')->flash();
                Helpers::redirecionar("admin/posts/listar");
            }
        }


        $categorias = (new CategoriaModelo())->buscaCategoria(); //Lista os dados das categorias na edição
        echo $this->template->rendenizar('posts/cadastrar.html', [
            'post' => $post,
            'categorias' => $categorias
        ]);
    }

    public function excluirPost(int $id): void
    {
        if (is_int($id)) {
            $post = (new PostModelo())->buscaPorId($id);
            if (!$post) {
                $this->mensagem->mensagemErro("Não foi possivel Realizar essa operação")->flash();
                Helpers::redirecionar("admin/posts/listar");
            } else {
                if ($post->apagar("id = {$id}")) {
                    $this->mensagem->mensagemSucesso("Post deletado com sucesso!")->flash();
                    Helpers::redirecionar("admin/posts/listar");
                }else{
                    $this->mensagem->mensagemErro("Houve um erro inesperado")->flash();
                    Helpers::redirecionar("admin/posts/listar");
                }
            }
        }
    }
}
