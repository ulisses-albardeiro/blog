<?php

namespace sistema\Nucleo;

use sistema\Nucleo\Conexao;
use sistema\Nucleo\Mensagem;

/**
 * Classe abstrata Modelo
 * Fornece a base para interações com o banco de dados, incluindo operações CRUD.
 *
 * @package sistema\Nucleo
 */
abstract class Modelo
{
    /**
     * Armazena os dados do modelo.
     * @var \stdClass|null
     */
    protected $dados;

    /**
     * Armazena a string da query SQL.
     * @var string|null
     */
    protected ?string $query = null;

    /**
     * Armazena o objeto de erro (Throwable) em caso de exceção.
     * @var \Throwable|null
     */
    protected ?\Throwable $erro = null;

    /**
     * Armazena os parâmetros para a execução da query.
     * @var array|null
     */
    protected ?array $parametros = null;

    /**
     * Nome da tabela no banco de dados.
     * @var string
     */
    protected string $tabela;

    /**
     * String para cláusula ORDER BY.
     * @var string|null
     */
    protected ?string $ordem = null;

    /**
     * String para cláusula LIMIT.
     * @var string|null
     */
    protected ?string $limite = null;

    /**
     * String para cláusula OFFSET.
     * @var string|null
     */
    protected ?string $offset = null;

    /**
     * Instância da classe Mensagem para manipulação de mensagens.
     * @var Mensagem
     */
    protected Mensagem $mensagem;

    /**
     * Construtor da classe Modelo.
     *
     * @param string $tabela O nome da tabela do banco de dados para este modelo.
     */
    public function __construct(string $tabela)
    {
        $this->tabela = $tabela;
        $this->mensagem = new Mensagem();
    }

    /**
     * Retorna os dados do modelo.
     *
     * @return \stdClass|null Um objeto stdClass contendo os dados do modelo ou null se não houver dados.
     */
    public function dados(): ?\stdClass
    {
        return $this->dados;
    }

    /**
     * Método mágico para definir propriedades dinamicamente no objeto de dados.
     *
     * @param string $nome  O nome da propriedade a ser definida.
     * @param mixed  $valor O valor a ser atribuído à propriedade.
     * @return mixed O valor que foi atribuído.
     */
    public function __set(string $nome, mixed $valor)
    {
        if (!$this->dados) {
            $this->dados = new \stdClass();
        }

        return $this->dados->$nome = $valor;
    }

    /**
     * Método mágico para verificar se uma propriedade existe no objeto de dados.
     *
     * @param string $nome O nome da propriedade a ser verificada.
     * @return bool True se a propriedade existir, false caso contrário.
     */
    public function __isset(string $nome): bool
    {
        return isset($this->dados->$nome);
    }

    /**
     * Método mágico para obter o valor de uma propriedade do objeto de dados.
     *
     * @param string $nome O nome da propriedade a ser obtida.
     * @return mixed O valor da propriedade ou null se não existir.
     */
    public function __get(string $nome): mixed
    {
        return $this->dados->$nome ?? null;
    }

    /**
     * Adiciona uma cláusula ORDER BY à consulta.
     *
     * @param string $ordem A string da ordem (ex: "id DESC", "nome ASC").
     * @return Modelo Retorna a própria instância do modelo para encadeamento.
     */
    public function ordem(string $ordem): Modelo
    {
        $this->ordem = " ORDER BY {$ordem} ";
        return $this;
    }

    /**
     * Adiciona uma cláusula LIMIT à consulta.
     *
     * @param string $limite A string do limite (ex: "10").
     * @return Modelo Retorna a própria instância do modelo para encadeamento.
     */
    public function limite(string $limite): Modelo
    {
        $this->limite = " LIMIT {$limite} ";
        return $this;
    }

    /**
     * Adiciona uma cláusula OFFSET à consulta.
     *
     * @param string $offset A string do offset (ex: "5").
     * @return Modelo Retorna a própria instância do modelo para encadeamento.
     */
    public function offset(string $offset): Modelo
    {
        $this->offset = " OFFSET {$offset} ";
        return $this;
    }

    /**
     * Retorna o último erro ocorrido durante uma operação.
     *
     * @return \Throwable|null O objeto Throwable do erro ou null se não houver erro.
     */
    public function erro(): ?\Throwable
    {
        return $this->erro;
    }

    /**
     * Retorna a instância da classe Mensagem.
     *
     * @return Mensagem A instância da classe Mensagem.
     */
    public function mensagem(): Mensagem
    {
        return $this->mensagem;
    }

    /**
     * Inicia uma busca no banco de dados.
     *
     * @param string|null $termos     Os termos da cláusula WHERE (ex: "id = :id").
     * @param string|null $parametros Os parâmetros da query como string (ex: "id=1&nome=teste").
     * @param string      $colunas    As colunas a serem selecionadas (padrão: "*").
     * @return Modelo Retorna a própria instância do modelo para encadeamento.
     */
    public function busca(?string $termos = null, ?string $parametros = null, string $colunas = '*'): Modelo
    {
        if ($termos) {
            $this->query = "SELECT {$colunas} FROM " . $this->tabela . " WHERE {$termos}";
            parse_str((string)$parametros, $this->parametros);

            return $this;
        }

        $this->query = "SELECT {$colunas} FROM " . $this->tabela;

        return $this;
    }

    /**
     * Executa a query construída e retorna o(s) resultado(s).
     *
     * @param bool $todos Se true, retorna todos os resultados como um array; caso contrário, retorna um único objeto.
     * @return array<mixed>|object|null Um array de resultados, um único objeto, ou null se não houver resultados ou ocorrer um erro.
     */
    public function resultado(bool $todos = false): array|object|null
    {
        try {
            $finalQuery = $this->query . ($this->ordem ?? '') . ($this->limite ?? '') . ($this->offset ?? '');

            $stmt = Conexao::getInstancia()->prepare($finalQuery);
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

    /**
     * Cadastra novos dados na tabela do modelo.
     *
     * @param array $dados Um array associativo com os dados a serem inseridos (chave => valor).
     * @return string|null O ID da última inserção ou null em caso de erro.
     */
    protected function cadastrar(array $dados): ?string
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

    /**
     * Atualiza dados existentes na tabela do modelo.
     *
     * @param array  $dados  Um array associativo com os dados a serem atualizados (chave => valor).
     * @param string $termos Os termos da cláusula WHERE para identificar o(s) registro(s) a ser(em) atualizado(s).
     * @return int|null O número de linhas afetadas pela atualização ou null em caso de erro.
     */
    protected function atualizar(array $dados, string $termos): ?int
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

            return ($stmt->rowCount());
        } catch (\Throwable $th) {
            echo $this->erro = $th;
            return null;
        }
    }

    /**
     * Apaga registro(s) da tabela do modelo.
     *
     * @param string $termos Os termos da cláusula WHERE para identificar o(s) registro(s) a ser(em) apagado(s).
     * @return bool|null True em caso de sucesso, ou null em caso de erro.
     */
    public function apagar(string $termos): ?bool
    {
        try {
            $query = "DELETE FROM " . $this->tabela . " WHERE {$termos}";
            $stmt = Conexao::getInstancia()->prepare($query);
            $stmt->execute();

            return true;
        } catch (\Throwable $th) {
            $this->erro = $th;
            return null;
        }
    }

    /**
     * Filtra os dados fornecidos, retornando apenas valores seguros.
     *
     * @param array $dados O array de dados a ser filtrado.
     * @return array O array de dados filtrado.
     */
    private function filtro(array $dados): array
    {
        $filtro = [];

        foreach ($dados as $chave => $valor) {
            $filtro[$chave] = (is_null($valor) ? null : filter_var($valor, FILTER_DEFAULT));
        }

        return $filtro;
    }

    /**
     * Converte os dados do modelo (stdClass) para um array.
     *
     * @return array Um array associativo contendo os dados do modelo.
     */
    protected function armazenar(): array
    {
        $dados = (array) $this->dados;
        return $dados;
    }

    /**
     * Busca um registro pelo ID na tabela do modelo.
     *
     * @param int $id O ID do registro a ser buscado.
     * @return object|null O objeto do registro encontrado ou null se não for encontrado.
     */
    public function buscaPorId(int $id): ?object
    {
        $busca = $this->busca("id = {$id}");

        return $busca->resultado();
    }

    /**
     * Salva os dados do modelo no banco de dados.
     * Realiza um cadastro se o modelo não tiver um ID, ou uma atualização se já tiver.
     *
     * @return bool True em caso de sucesso (cadastro ou atualização), false em caso de erro.
     */
    public function salvar(): bool
    {
        if (empty($this->id)) {
            $this->cadastrar($this->armazenar());
            if ($this->erro) {
                return false;
            }
        }

        if (!empty($this->id)) {
            $id = $this->id;
            $this->atualizar($this->armazenar(), "id = {$id}");
            if ($this->erro) {
                return false;
            }
            $result = $this->buscaPorId($id);
            $this->dados = $result->dados;
        }
        return true;
    }
}