<?php

namespace sistema\Controlador\Admin;

use sistema\Modelos\UsuarioModelo;
use sistema\Nucleo\Helpers;

class AdminUsuarios extends AdminControlador
{
    public function usuarios(): void
    {
        $usuarios = (new UsuarioModelo())->busca()->resultado(true);

        echo $this->template->rendenizar('usuarios/listar.html', [
            'usuarios' => $usuarios
        ]);
    }

    public function cadastrarUsuario(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($dados)) {
            $usuario = new UsuarioModelo;
            $usuario->nome = $dados['nome'];
            $usuario->email = $dados['email'];
            $usuario->cpf = $dados['cpf'];
            $usuario->senha = $dados['senha'];
            if ($usuario->salvar()) {
                $this->mensagem->mensagemSucesso('Post cadastrado com sucesso')->flash();
                Helpers::redirecionar('admin/usuarios/listar');
            }
        }

        //lista no select as categorias
        $categorias = (new UsuarioModelo())->busca()->resultado(true);
        echo $this->template->rendenizar('usuarios/cadastrar.html', [
            'categorias' => $categorias
        ]);
    }

    public function editarUsuario(int $id): void
    {
        $usuario = (new UsuarioModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            //(new PostModelo())->atualizarPost($id, $dados);
            $usuario = new UsuarioModelo;
            $usuario->nome = $dados['nome'];
            $usuario->email = $dados['email'];
            $usuario->cpf = $dados['cpf'];
            $usuario->senha = $dados['senha'];

            if ($usuario->salvar()) {
                $this->mensagem->mensagemSucesso('Post editado com sucesso')->flash();
                Helpers::redirecionar("admin/usuarios/listar");
            }
        }

        echo $this->template->rendenizar('usuarios/cadastrar.html', [
            'usuario' => $usuario,
        ]);
    }


    public function excluirUsuario(int $id): void
    {
        if (is_int($id)) {
            $usuario = (new UsuarioModelo())->buscaPorId($id);
            if (!$usuario) {
                $this->mensagem->mensagemErro("Não foi possivel Realizar essa operação")->flash();
                Helpers::redirecionar("admin/usuarios/listar");
            } else {
                if ($usuario->apagar("id = {$id}")) {
                    $this->mensagem->mensagemSucesso("Usuário deletado com sucesso!")->flash();
                    Helpers::redirecionar("admin/usuarios/listar");
                } else {
                    $this->mensagem->mensagemErro("Houve um erro inesperado")->flash();
                    Helpers::redirecionar("admin/usuarios/listar");
                }
            }
        }
    }
}
