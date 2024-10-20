<?php

namespace sistema\Controlador;

use sistema\Nucleo\Controlador;

class SiteControlador extends Controlador 
{
    public function __construct()
    {
        parent::__construct('templates/site/views');
    }        
    

    public function index():void
    {
        echo $this->template->rendenizar('index.html', [
            'titulo' => 'Principal',
            'subtitulo' => 'teste de subtitulo'
        ]);
    }

    public function sobre():void
    {
        echo $this->template->rendenizar('sobre.html', [
            'titulo' => 'Sobre',
            'subtitulo' => 'teste de subtitulo'
        ]);
    }


    public function erro404():void
    {
        echo $this->template->rendenizar('404.html', [
            'titulo' => 'Página não encontrada'
        ]);
    }
}