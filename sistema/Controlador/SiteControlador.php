<?php

namespace sistema\Controlador;
use sistema\Modelos\PostModelo;
use sistema\Nucleo\Controlador;

class SiteControlador extends Controlador 
{
    public function __construct()
    {
        parent::__construct('templates/site/views');
    }        
    

    public function index():void
    {
        $posts = (new PostModelo())->busca();
        echo $this->template->rendenizar('index.html', [
            'titulo' => 'Principal',
            'posts' => $posts //retorna os dados dos posts para a index
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