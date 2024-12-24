<?php

namespace sistema\Controlador;

use sistema\Modelos\CategoriaModelo;
use sistema\Modelos\PostModelo;
use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;

class SiteControlador extends Controlador
{
    public function __construct()
    {
        parent::__construct('templates/site/views');
    }


    public function index(): void
    {
        $posts = (new PostModelo())->busca()->ordem('id DESC')->limite(6); //Busca o titulo e textos do post
        $categorias = (new CategoriaModelo())->busca()->resultado(true); //Busca a categoria e a descrição
        echo $this->template->rendenizar('index.html', [
            'titulo' => 'Ulisses Alba - Home',
            'posts' => $posts->resultado(true), //retorna os dados da tabela posts para a index
            'categorias' => $categorias //retorna os dados da tabela categoria para a index
        ]);
    }

    public function pesquisa(): void
    {
        $pesquisa = filter_input(INPUT_POST, 'pesquisa', FILTER_DEFAULT);

        if (isset($pesquisa)) {
            $posts = (new PostModelo())->busca("status = 1 AND titulo LIKE '%{$pesquisa}%'")->resultado(true);
            $categorias = (new CategoriaModelo())->busca()->resultado(true);

            echo $this->template->rendenizar('pesquisa.html', [
                'titulo' => 'Ulisses Alba - Pesquisa',
                'posts' => $posts,
                'categorias' => $categorias
            ]);
        }
    }

    public function blog(): void
    {
        $categorias = (new CategoriaModelo())->busca()->resultado(true); //Busca a categoria e a descrição
        $metade = ceil(count($categorias) / 2);

        // Divide as categorias em duas partes
        $categoriasEsquerda = array_slice($categorias, 0, $metade);
        $categoriasDireita = array_slice($categorias, $metade);

        $posts = (new PostModelo)->busca()->resultado(true);

        echo $this->template->rendenizar('blog.html', [
            'titulo' => 'Ulisses Alba - Blog',

            'categoriasEsquerda' => $categoriasEsquerda,
            'categoriasDireita' => $categoriasDireita,

            'posts' => $posts

        ]);
    }

    public function post(int $id): void
    {
        $post = (new PostModelo())->busca('id = :id', 'id=' . $id)->resultado();
        $categorias = (new CategoriaModelo())->busca()->resultado(true); //Busca a categoria e a descrição
        $categoria = (new CategoriaModelo())->busca('id = :id', 'id=' .$post->categoria_id)->resultado();

        // Divide as categorias em duas partes
        $metade = ceil(count($categorias) / 2);
        $categoriasEsquerda = array_slice($categorias, 0, $metade);
        $categoriasDireita = array_slice($categorias, $metade);

        if (!$post) {
            Helpers::redirecionar('404');
        }

        //envia dados para a página post
        echo $this->template->rendenizar('post.html', [
            'post' => $post,
            'categoria' => $categoria,
            'categoriasEsquerda' => $categoriasEsquerda,
            'categoriasDireita' => $categoriasDireita,
            'titulo' => $post->titulo
        ]);
    }

    public function categorias(int $id): void
    {
        $posts = (new PostModelo())->busca('categoria_id = :id', 'id=' . $id)->resultado(true);
        $categorias = (new CategoriaModelo())->busca()->resultado(true);

        $categoria = (new CategoriaModelo())->busca('id = :id', 'id=' .$id)->resultado();

        // Divide as categorias em duas partes
        $metade = ceil(count($categorias) / 2);
        $categoriasEsquerda = array_slice($categorias, 0, $metade);
        $categoriasDireita = array_slice($categorias, $metade);

        echo $this->template->rendenizar('categorias.html', [
            'posts' => $posts,

            'categoria' => $categoria,
            'categoriasEsquerda' => $categoriasEsquerda,
            'categoriasDireita' => $categoriasDireita
        ]);
    }


    public function erro404(): void
    {
        echo $this->template->rendenizar('404.html', [
            'titulo' => 'Página não encontrada'
        ]);
    }
}
