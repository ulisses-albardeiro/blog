<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;
use sistema\Nucleo\Sessao;
use sistema\Modelos\UsuarioModelo;

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
            } else {
                $usuario = (new UsuarioModelo())->login($dados);

                if ($usuario) {
                    Helpers::redirecionar('admin/dashboard');
                }
            }
        }
    }

    public function checarDados(array $dados): bool
    {
        if (empty($dados['usuario'])) {
            return false;
        }

        return true;
    }
}
