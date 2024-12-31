<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;
use sistema\Modelos\UsuarioModelo;
use sistema\Controlador\UsuarioControlador;

class AdminLogin extends Controlador
{
    public function __construct()
    {
        parent::__construct('templates/admin/views');
    }



    public function login()
    {

        echo $this->template->rendenizar('login.html', []);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($dados)) {
            if (in_array("", $dados)) {
                $this->mensagem->mensagemAtencao("Preencha todos os campos!")->flash();
                Helpers::redirecionar('admin/login');
            } else {
                $login = (new UsuarioModelo())->login($dados);

                if ($login) {
                    $usuario = new UsuarioControlador;
                    $nome = $usuario->usuario();

                    $this->mensagem->mensagemSucesso("Bem vindo, {$nome->nome}")->flash();
                    Helpers::redirecionar('admin/dashboard');
                } else {
                    $this->mensagem->mensagemErro("Dados incorretos")->flash();
                    Helpers::redirecionar('admin/login');
                }
            }
        }
    }

    public function checarDados(array $dados): bool
    {
        if (empty($dados['usuario']) or empty($dados['usuario'])) {
            return false;
        }

        return true;
    }
}
