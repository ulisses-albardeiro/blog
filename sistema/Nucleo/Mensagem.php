<?php

namespace sistema\Nucleo;

/**
 * Classe Mensagem
 *
 * Gerencia a criação e exibição de mensagens de feedback (sucesso, erro, atenção)
 * formatadas para serem exibidas em interfaces de usuário.
 * As mensagens são renderizadas como elementos HTML de alerta.
 *
 * @package sistema\Nucleo
 */
class Mensagem
{
    /**
     * O conteúdo textual da mensagem.
     * @var string
     */
    private $texto;

    /**
     * A classe CSS para estilizar o tipo de mensagem (sucesso, erro, atenção).
     * @var string
     */
    private $css;

    /**
     * Método mágico que define como o objeto Mensagem deve ser tratado ao ser convertido para string.
     *
     * @return string O HTML renderizado da mensagem.
     */
    public function __toString(): string
    {
        return $this->rendenizar();
    }

    /**
     * Configura a mensagem como um alerta de sucesso.
     * O texto da mensagem é filtrado para segurança.
     *
     * @param string $mensagem O texto da mensagem de sucesso.
     * @return Mensagem Retorna a própria instância da classe para encadeamento de métodos.
     */
    public function mensagemSucesso(string $mensagem): Mensagem
    {
        $this->css = 'alert alert-success';
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }

    /**
     * Configura a mensagem como um alerta de erro.
     * O texto da mensagem é filtrado para segurança.
     *
     * @param string $mensagem O texto da mensagem de erro.
     * @return Mensagem Retorna a própria instância da classe para encadeamento de métodos.
     */
    public function mensagemErro(string $mensagem): Mensagem
    {
        $this->css = 'alert alert-danger';
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }

    /**
     * Configura a mensagem como um alerta de atenção (aviso).
     * O texto da mensagem é filtrado para segurança.
     *
     * @param string $mensagem O texto da mensagem de atenção.
     * @return Mensagem Retorna a própria instância da classe para encadeamento de métodos.
     */
    public function mensagemAtencao(string $mensagem): Mensagem
    {
        $this->css = 'alert alert-warning';
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }

    /**
     * Renderiza a mensagem em formato HTML.
     *
     * @return string O código HTML completo do alerta, incluindo o botão de fechar.
     */
    public function rendenizar(): string
    {
        return "<div class='{$this->css} alert alert-dismissible fade show d-flex justify-content-between align-items-center' role='alert'>
                <span>{$this->texto}</span>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Fechar'></button>
            </div>";
    }

    /**
     * Filtra a string da mensagem para prevenir ataques XSS.
     * Utiliza FILTER_SANITIZE_SPECIAL_CHARS para converter caracteres especiais em entidades HTML.
     *
     * @param string $mensagem A mensagem a ser filtrada.
     * @return string A mensagem segura.
     */
    private function filtrar(string $mensagem): string
    {
        return filter_var($mensagem, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * Armazena a mensagem atual na sessão como uma "flash message".
     *
     * @return void
     */
    public function flash(): void
    {
        (new Sessao())->criarSessao('flash', $this);
    }
}
