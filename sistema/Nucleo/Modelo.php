<?php

namespace sistema\Nucleo;

use sistema\Nucleo\Conexao;
use sistema\Nucleo\Mensagem;

abstract class Modelo
{
    protected $dados;
    protected $query;
    protected $erro;
    protected $parametros;
    protected $tabela;
    protected $ordem;
    protected $limite;
    protected $offset;
    protected $mensagem;

    public function __construct(string $tabela)
    {
        $this->tabela = $tabela;

        $this->mensagem = new Mensagem;
    }

    public function dados()
    {
        return $this->dados;
    }

    public function __set($nome, $valor)
    {
        if (!$this->dados) {
            $this->dados = new \stdClass();
        }

        return $this->dados->$nome = $valor;
    }

    public function __isset($nome)
    {
        return isset($this->dados->$nome);
    }

    public function __get($nome)
    {
        return $this->dados->$nome ?? null;
    }

    public function ordem(string $ordem)
    {
        $this->ordem = " ORDER BY {$ordem} ";
        return $this;
    }

    public function limite(string $limite)
    {
        $this->limite = " LIMIT {$limite} ";
        return $this;
    }

    public function offset(string $offset)
    {
        $this->offset = " OFFSET {$offset} ";
        return $this;
    }

    public function erro()
    {
        return $this->erro;
    }

    public function mensagem()
    {
        return $this->mensagem;
    }

    function busca(?string $termos = null, ?string $parametros = null, string $colunas = '*')
    {
        if ($termos) {
            $this->query = "SELECT {$colunas} FROM " . $this->tabela . " WHERE {$termos}";
            parse_str($parametros, $this->parametros);

            return $this;
        }

        $this->query = "SELECT {$colunas} FROM " . $this->tabela;

        return $this;
    }

    public function resultado(bool $todos = false)
    {
        try {
            $stmt = Conexao::getInstancia()->prepare($this->query . $this->ordem . $this->limite . $this->offset);
            $stmt->execute($this->parametros);

            if (!$stmt->rowCount()) {
                return null;
            }
            if ($todos) {
                return $stmt->fetchAll();
            }

            return $stmt->fetchObject(static::class);
        } catch (\Throwable $th) {
            $this->erro = $th;
            return null;
        }
    }

    protected function cadastrar(array $dados)
    {
        try {
            $colunas = implode(",",  array_keys($dados));
            $valores = ":" . implode(", :", array_keys($dados));

            $query = "INSERT INTO " . $this->tabela . " ({$colunas}) VALUES ({$valores})";
            $stmt = Conexao::getInstancia()->prepare($query);
            $stmt->execute($this->filtro($dados));

            return Conexao::getInstancia()->lastInsertId();
        } catch (\Throwable $th) {
            echo $this->erro = $th;
            return null;
        }
    }

    protected function atualizar(array $dados, string $termos)
    {
        try {
            $set = [];

            foreach ($dados as $chave => $valor) {
                $set[] = "{$chave} = :{$chave}";
            }
            $set = implode(', ', $set);

            $query = "UPDATE " . $this->tabela . " SET {$set} WHERE {$termos}";
            $stmt = Conexao::getInstancia()->prepare($query);
            $stmt->execute($this->filtro($dados));

            return ($stmt->rowCount() ?? 1);
        } catch (\Throwable $th) {
            echo $this->erro = $th;
            return null;
        }
    }

    public function apagar(string $termos)
    {
        try {
            $query = "DELETE FROM " . $this->tabela . " WHERE {$termos}";
            $stmt = Conexao::getInstancia()->prepare($query);
            $stmt->execute();

            return true;
        } catch (\Throwable $th) {
            $this->erro = $th->getMessage();

            return null;
        }
    }

    private function filtro(array $dados)
    {
        $filtro = [];

        foreach ($dados as $chave => $valor) {
            $filtro[$chave] = (is_null($valor) ? null : filter_var($valor, FILTER_DEFAULT));
        }

        return $filtro;
    }

    protected function armazenar()
    {
        $dados = (array) $this->dados;
        return $dados;
    }

    public function buscaPorId(int $id)
    {
        $busca = $this->busca("id = {$id}");

        return $busca->resultado();
    }

    public function salvar()
    {
        //Cadastrar
        if (empty($this->id)) {
            $this->cadastrar($this->armazenar());
            if ($this->erro) {
                return false;
            }
        }

        //Editar
        if (!empty($this->id)) {
            $id = $this->id;
            $this->atualizar($this->armazenar(), "id = {$id}");
            if ($this->erro) {
                return false;
            }

            $this->dados = $this->buscaPorId($id)->dados;
        }
        return true;
    }
}
