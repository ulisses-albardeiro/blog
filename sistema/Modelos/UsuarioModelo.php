<?php

namespace sistema\Modelos;

use sistema\Nucleo\Modelo;
use sistema\Nucleo\Sessao;

class UsuarioModelo extends Modelo
{
    public function __construct()
    {
        parent::__construct("usuarios");
    }

    public function buscaPorUsuario(string $email): ?UsuarioModelo
    {
        $busca = $this->busca("email = :e", ":e={$email}"); //IMPORTANTE manter os espaços nessa ordem
        return $busca->resultado();
    }

    public function login(array $dados, int $nivel = 1)
    {
        $usuario = (new UsuarioModelo())->buscaPorUsuario($dados['usuario']);


        if (!$usuario) {
            $this->mensagem->mensagemErro("Dados incorretos")->flash();

            return false;
        }

        (new Sessao)->criarSessao('usuarioId', $usuario->id);

        $this->mensagem->mensagemSucesso("Bem vindo, {$usuario->nome}")->flash();

        return true;
    }
}
