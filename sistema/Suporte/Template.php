<?php

namespace sistema\Suporte;

use sistema\Controlador\UsuarioControlador;
use Twig\Lexer;
use sistema\Nucleo\Helpers;

/**
 * Classe Template
 *
 * Responsável por configurar e gerenciar o motor de templates Twig,
 * permitindo a renderização de views e a disponibilização de funções auxiliares.
 *
 * @package sistema\Suporte
 */
class Template
{
    /**
     * Instância do ambiente Twig.
     *
     * @var \Twig\Environment
     */
    private \Twig\Environment $twig;

    /**
     * Construtor da classe Template.
     *
     * Inicializa o ambiente Twig com o diretório de templates especificado
     * e configura as funções auxiliares disponíveis nas views.
     *
     * @param string $diretorio O caminho para o diretório onde os arquivos de template estão localizados.
     */
    public function __construct(string $diretorio)
    {
        $loader = new \Twig\Loader\FilesystemLoader($diretorio);
        $this->twig = new \Twig\Environment($loader);

        $lexer = new Lexer($this->twig, array(
            $this->helpers()
        ));
        $this->twig->setLexer($lexer);
    }

    /**
     * Renderiza um arquivo de template Twig.
     *
     * @param string $view  O nome do arquivo de template a ser renderizado (ex: 'pagina/home.html').
     * @param array  $dados Um array associativo de dados a serem passados para o template.
     * @return string O conteúdo HTML renderizado do template.
     */
    public function rendenizar(string $view, array $dados): string
    {
        return $this->twig->render($view, $dados);
    }

    /**
     * Adiciona funções auxiliares (helpers) personalizadas ao ambiente Twig.
     *
     * Estas funções podem ser chamadas diretamente nos templates Twig para realizar
     * operações comuns, como gerar URLs, resumir textos, exibir mensagens flash,
     * obter dados do usuário logado e formatar tempo.
     *
     * @return void Este método não retorna nenhum valor diretamente, mas configura o objeto Twig.
     */
    private function helpers(): void
    {
        array(
            $this->twig->addFunction(
                new \Twig\TwigFunction('url', function (?string $url = null) {
                    return Helpers::url($url);
                })
            ),

            $this->twig->addFunction(
                new \Twig\TwigFunction('textoResumido', function (string $text, int $limit, string $continues = '...') {
                    return Helpers::textoResumido($text, $limit, $continues);
                })
            ),

            $this->twig->addFunction(
                new \Twig\TwigFunction('flash', function () {
                    return Helpers::flash();
                }),

                $this->twig->addFunction(
                    new \Twig\TwigFunction('usuario', function () {
                        return UsuarioControlador::usuario();
                    })
                )
            ),

            $this->twig->addFunction(
                new \Twig\TwigFunction('contagemTempo', function (string $date) {
                    return Helpers::contagemTempo($date);
                }),
            ),

            $this->twig->addFunction(
                new \Twig\TwigFunction('decodeHtml', function (string $texto) {
                    return Helpers::decodeHtml($texto);
                }),
            ),
        );
    }
}
