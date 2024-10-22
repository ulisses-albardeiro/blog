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
    

    public function index():void
    {
        $posts = (new PostModelo())->busca();//Busca o titulo e textos do post
        $categorias = (new CategoriaModelo())->buscaCategoria(); //Busca a categoria e a descrição
        echo $this->template->rendenizar('index.html', [
            'titulo' => 'Principal',
            'posts' => $posts, //retorna os dados da tabela posts para a index
            'categorias' => $categorias //retorna os dados da tabela categoria para a index
        ]);
    }

    public function sobre():void
    {
        echo $this->template->rendenizar('sobre.html', [
            'titulo' => 'Sobre',
        ]);
    }

    public function post(int $id):void
    {
        $post = (new PostModelo())->buscaPorId($id);
        if(!$post){
            Helpers::redirecionar('404');
        }
        echo $this->template->rendenizar('post.html', [
            'post' => $post
        ]);
    }


    public function erro404():void
    {
        echo $this->template->rendenizar('404.html', [
            'titulo' => 'Página não encontrada'
        ]);
    }
}