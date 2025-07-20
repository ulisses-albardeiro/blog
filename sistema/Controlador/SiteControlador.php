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
        $posts = (new PostModelo())->busca("status = 1")->ordem('id DESC')->resultado(true) ?? []; 
        $categorias = (new CategoriaModelo())->busca("status = 1")->resultado(true) ?? []; 

        // Divide as categorias em duas partes para apresentar na view
        $metade = ceil(count($categorias) / 2);
        $categoriasEsquerda = array_slice($categorias, 0, $metade);
        $categoriasDireita = array_slice($categorias, $metade);

        echo $this->template->rendenizar('index.html', [
            'titulo' => 'Ulisses Albardeiro',
            'posts' => $posts, 

            'categoriasEsquerda' => $categoriasEsquerda,
            'categoriasDireita' => $categoriasDireita
        ]);
    }

    public function contato(): void
    {
        echo $this->template->rendenizar('contato.html', []);
    }

    public function pesquisa(): void
    {
        $pesquisa = filter_input(INPUT_POST, 'pesquisa', FILTER_DEFAULT);

        if (isset($pesquisa)) {
            $posts = (new PostModelo())->busca("status = 1 AND (titulo LIKE '%{$pesquisa}%' OR texto LIKE '%{$pesquisa}%')")->resultado(true);

            // Divide as categorias em duas partes para apresentar na view
            $categorias = (new CategoriaModelo())->busca()->resultado(true);
            $metade = ceil(count($categorias) / 2);
            $categoriasEsquerda = array_slice($categorias, 0, $metade);
            $categoriasDireita = array_slice($categorias, $metade);

            echo $this->template->rendenizar('pesquisa.html', [
                'titulo' => 'Ulisses Alba - Pesquisa',
                'posts' => $posts,

                'pesquisa' => $pesquisa,

                'categoriasEsquerda' => $categoriasEsquerda,
                'categoriasDireita' => $categoriasDireita
            ]);
        }
    }

    public function post(string $slug): void
    {
        $post = (new PostModelo())->busca('slug = :slug', 'slug=' . $slug)->resultado();
        $categorias = (new CategoriaModelo())->busca()->resultado(true); 
        $categoria = (new CategoriaModelo())->busca('id = :id', 'id=' . $post->categoria_id)->resultado();

        // Divide as categorias em duas partes para apresentar na view
        $metade = ceil(count($categorias) / 2);
        $categoriasEsquerda = array_slice($categorias, 0, $metade);
        $categoriasDireita = array_slice($categorias, $metade);

        if (!$post) {
            Helpers::redirecionar('404');
        }

        echo $this->template->rendenizar('post.html', [
            'post' => $post,
            'categoria' => $categoria,
            'categoriasEsquerda' => $categoriasEsquerda,
            'categoriasDireita' => $categoriasDireita,
            'titulo' => $post->titulo
        ]);

        //Contagem de Visualizações
        $post->visitas += 1;
        $post->ultima_visita = date('Y-m-d H:m:s');
        $post->salvar();
    }

    public function categorias(string $slug): void
    {
        $categorias = (new CategoriaModelo())->busca()->resultado(true);
        $categoria = (new CategoriaModelo())->busca('slug = :s', ':s='.$slug)->resultado();
        $posts = (new PostModelo())->busca("categoria_id = '{$categoria->id}' AND status = 1")->resultado(true);

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
