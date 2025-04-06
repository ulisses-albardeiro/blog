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

    public function login(array $dados)
    {
        $usuario = $this->validacao($dados['usuario'], $dados['senha']);

        if (!$usuario) {
            return false;
        }

        (new Sessao)->criarSessao('usuarioId', $usuario->id);

        $this->mensagem->mensagemSucesso("Bem vindo, {$usuario->nome}")->flash();
        return true;
    }

    public function validacao(string $usuario, string $senha): ?UsuarioModelo
    {   
        $busca_usuario = $this->busca("email = :email", ":email={$usuario}")->resultado();
        
        if ($busca_usuario && password_verify($senha, $busca_usuario->senha)) {
            
            return $busca_usuario;
        }
        return null;
    }

}
