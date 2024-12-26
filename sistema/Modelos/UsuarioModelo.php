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

    public function buscaPorUsuario(string $usuario): ?UsuarioModelo
    {
        $busca = $this->busca("email = :e", ":e={$usuario}");
        return $busca->resultado();
    }

    public function login(array $dados)
    {
        $usuario = $this->buscaPorUsuario($dados['usuario']);


        if (!$usuario) {
            $this->mensagem->mensagemErro("Dados incorretos")->flash();

            return false;
        }

        (new Sessao)->criarSessao('usuarioId', $usuario->id);

        $this->mensagem->mensagemSucesso("Bem vindo, {$usuario->nome}")->flash();

        return true;
    }
}
