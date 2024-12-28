<?php

namespace sistema\Biblioteca;


class Upload
{
    public $diretorio;
    public $arquivo;
    public $nome;
    public $diretorioFilho;
    public $tamanho;
    public $resultado;
    public $erro;

    public function __construct(string $diretorio = null)
    {
        $this->diretorio = $diretorio ?? 'uploads';

        if (!file_exists($this->diretorio) && !is_dir($this->diretorio)) {
            mkdir($this->diretorio, 0755);
        }
    }

    public function getResultado(): ?string
    {
        return $this->resultado;
    }

    public function getErro(): ?string
    {
        return $this->erro;
    }


    public function arquivo(array $arquivo, string $nome = null,  string $diretorioFilho = null, int $tamanho = null): void
    {
        $this->arquivo = $arquivo;
        $this->nome = $nome ?? pathinfo($this->arquivo['name'], PATHINFO_FILENAME);
        $this->diretorioFilho = $diretorioFilho ?? 'arquivos';
        $this->tamanho = $tamanho ?? 1;

        $extencaoArquivo = pathinfo($this->arquivo['name'], PATHINFO_EXTENSION);
        $extencoesPermitidas = ['pdf', 'png', 'jpeg', 'jpg'];
        $mimetypeArquivo = $this->arquivo['type'];
        $mimetypesPermitidas = ['application/pdf', 'image/png', 'image/jpeg', 'image/jpg'];

        if (!in_array($extencaoArquivo, $extencoesPermitidas)) {
            $this->erro = 'exteção de arquivo não permitida, somente ' . implode(" .", $extencoesPermitidas);
        } elseif (!in_array($mimetypeArquivo, $mimetypesPermitidas)) {
            $this->erro = 'Tipo de arquivo não permitido';
        }elseif($this->arquivo['size'] > $this->tamanho * (1024 * 1024)){
            $this->erro = 'Arquivo maior que o permitido, tamanho máximo de '. $this->tamanho * (1024 * 1024).'MB e o seu arquivo tem '.$this->arquivo['size'].'MB';
        }
         else {
            $this->criarDiretorioFilho();
            $this->renomearArquivo();
            $this->moverArquivo();
        }
    }

    public function renomearArquivo(): void
    {
        $arquivo = strrchr($this->arquivo['name'], '.');

        if (file_exists($this->diretorio . DIRECTORY_SEPARATOR . $this->diretorioFilho . DIRECTORY_SEPARATOR . $arquivo)) {

            $arquivo = $this->nome . '-' . uniqid() . strchr($this->arquivo['name'], '.');
        }
        $this->nome = $arquivo;
    }

    public function criarDiretorioFilho(): void
    {
        if (!file_exists($this->diretorio . DIRECTORY_SEPARATOR . $this->diretorioFilho) && !is_dir($this->diretorio . DIRECTORY_SEPARATOR . $this->diretorioFilho)) {

            mkdir($this->diretorio . DIRECTORY_SEPARATOR . $this->diretorioFilho, 0755);
        }
    }

    public function moverArquivo(): void
    {
        if (move_uploaded_file($this->arquivo['tmp_name'], $this->diretorio . DIRECTORY_SEPARATOR . $this->diretorioFilho . DIRECTORY_SEPARATOR . $this->nome)) {
            $this->resultado = $this->nome;
        } else {
            $this->resultado = null;
            $this->erro = 'erro ao mover arquivo';
        }
    }
}
