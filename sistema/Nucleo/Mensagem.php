<?php

namespace sistema\Nucleo;

class Mensagem
{
    private $texto;
    private $css;

    public function __toString()
    {
        return $this->rendenizar();
    }

    public function sucesso(string $mensagem): Mensagem
    {
        $this->css = 'alert alert-success';
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }

    public function rendenizar(): string
    {
        return "<div class='{$this->css}'>{$this->texto}</div>";
    }

    private function filtrar(string $mensagem): string
    {
        return filter_var($mensagem, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}