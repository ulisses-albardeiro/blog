<?php

namespace sistema\Controlador\Admin;

use sistema\Biblioteca\Upload;
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

        //Salva a imagem vinda do editor
        if (isset($_FILES['Imagem-editor'])) {
            $upload_img = new Upload('templates/site/assets/img');
            $upload_img->arquivo($_FILES['Imagem-editor'], uniqid(), 'posts');
            if ($upload_img->getResultado()) {
                $nome_img = $upload_img->getResultado();
                echo json_encode([
                    'success' => true,
                    'file' => Helpers::url('templates/site/assets/img/posts/' . $nome_img)
                ]);
                exit;
            }
        }

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($_FILES['tumb'])) {
            $upload = new Upload('templates/site/assets/img');
            $upload->arquivo($_FILES['tumb'], Helpers::slug($dados['titulo']), 'tumbs');
            if ($upload->getResultado()) {
                $nomeArquivo = $upload->getResultado();
            }
        }

        if (isset($dados)) {
            $post = new PostModelo;
            $post->titulo = $dados['titulo'];
            $post->categoria_id = $dados['categoria_id'];
            $post->texto = $dados['texto'];
            $post->status = $dados['status'];
            $post->tumb = $nomeArquivo;
            $post->slug = Helpers::slug($dados['titulo']);
            if ($post->salvar()) {
                $this->mensagem->mensagemSucesso('Post cadastrado com sucesso')->flash();
                Helpers::redirecionar('admin/posts/listar');
            }
        }

        //lista no select as categorias
        $categorias = (new CategoriaModelo())->busca()->resultado(true);
        echo $this->template->rendenizar('posts/cadastrar.html', [
            'categorias' => $categorias
        ]);
    }


    public function editarPost(int $id)
    {
        $post = (new PostModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if (isset($_FILES['tumb'])) {
                $upload = new Upload('templates/site/assets/img');
                $upload->arquivo($_FILES['tumb'], Helpers::slug($dados['titulo']), 'tumbs');
                if ($upload->getResultado()) {
                    $post->tumb = $upload->getResultado();//passa o valor para o BD
                } else {
                    $this->mensagem->mensagemErro($upload->getErro())->flash();
                }
            } else {
                $this->mensagem->mensagemAtencao('A tumb do post é obrigatória')->flash();
                exit;
            }

            $post = (new PostModelo())->buscaPorId($id);
            $post->titulo = $dados['titulo'];
            $post->categoria_id = $dados['categoria_id'];
            $post->texto = $dados['texto'];
            $post->status = $dados['status'];
            $post->slug = Helpers::slug($dados['titulo']);

            if ($post->salvar()) {
                $this->mensagem->mensagemSucesso('Post editado com sucesso')->flash();
                Helpers::redirecionar("admin/posts/listar");
            }
        }


        $categorias = (new CategoriaModelo())->busca()->resultado(true); //Lista os dados das categorias na edição
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
                $arquivo = $post->tumb;
                if ($post->apagar("id = {$id}")) {

                    unlink("templates/site/assets/img/tumbs/$arquivo");

                    $this->mensagem->mensagemSucesso("Post deletado com sucesso!")->flash();
                    Helpers::redirecionar("admin/posts/listar");
                } else {
                    $this->mensagem->mensagemErro("Houve um erro inesperado")->flash();
                    Helpers::redirecionar("admin/posts/listar");
                }
            }
        }
    }
}
