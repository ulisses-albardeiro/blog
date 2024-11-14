<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;
use sistema\Controlador\UsuarioControlador;
use sistema\Nucleo\Sessao;

class AdminControlador extends Controlador
{
    protected $usuario;

    public function __construct()
    {
        parent::__construct('templates/admin/views');

        $this->usuario = UsuarioControlador::usuario();

        if(!$this->usuario){
            $this->mensagem->mensagemErro('Necessário fazer login!')->flash();

            $sessao = new Sessao;
            $sessao->limparSessao('usuarioId');

            Helpers::redirecionar('admin/login');
        }

    }

   
}