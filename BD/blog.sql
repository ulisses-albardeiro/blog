-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 24/01/2025 às 23:45
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `blog`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(250) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `data_categoria` datetime DEFAULT current_timestamp(),
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `titulo`, `descricao`, `status`, `data_categoria`, `slug`) VALUES
(14, 'PHP', '   Falando do PHP', 1, '2025-01-05 11:57:59', 'php'),
(15, 'Desenvolvimento Pessoal', '   Posts sobre desenvolvimento pessoal.', 1, '2025-01-05 18:06:51', 'desenvolvimento-pessoal');

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `titulo` varchar(250) NOT NULL,
  `texto` text DEFAULT NULL,
  `tumb` varchar(255) DEFAULT NULL,
  `visitas` int(11) DEFAULT NULL,
  `ultima_visita` datetime DEFAULT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0,
  `categoria_id` int(11) DEFAULT NULL,
  `data_post` datetime DEFAULT current_timestamp(),
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`id`, `titulo`, `texto`, `tumb`, `visitas`, `ultima_visita`, `data_cadastro`, `status`, `categoria_id`, `data_post`, `slug`) VALUES
(1, 'Twig e suas vantagens no projeto', '<p>Talvez a maior crítica que fazem ao PHP é a respeito do famigerado “código macarrônico”, uma sequência de HTML, CSS e até JavaScript intercalado com PHP, uma bagunça que é terrível de dar manutenção. Mas quem programa ao melhor estilo “PHP: The Right Way” é gente de bem e não faz esse tipo de barbaridade (rs), pois é perfeitamente possível utilizar PHP puro e deixar a lógica com uma boa separação das views, mas isso ainda implica e ter um documento .php, alguns if’s, else’s e echo’s... ou no mínimo algumas short tags (&lt;?= ?&gt;).<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>Mas para quem quer ir além e ter zero PHP e a paz de espírito de um documento .html e ainda ter um site dinâmico, a solução é simples e passa em colocar uma Engine Template em seu projeto.<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>O que é uma Engine Template?<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>Engine Template é uma ferramenta que possibilita a separação da lógica de apresentação (HTML) da lógica de negócios (PHP), tornando assim o código ainda mais limpo.<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>Um exemplo muito conhecido e usado na comunidade PHP é o Twig Template, que pode ser implementado com PHP puro ou com frameworks como Laravel, Codeigniter, Symfony (criadores do Twig), entre outros.<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>Como mostrar Dados nas views?<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>É inevitável tem alguma manipulação de dados nas views, e no caso do Twig, ele consegue ter acesso a variáveis enviadas diretamente dos Controllers para as Views por meio de arrays associativos, tratados com uma DSL (Domain-Specific Language), que basicamente é uma linguagem do próprio template altamente abstraída e acessível até para designers que não são programadores.<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>Ex.:<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><img src=\"https://albaweb.com.br/templates/site/assets/img/posts/677abcd8e4f1e.png\" alt=\"\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>Também é possível utilizar os métodos diretamente, adicionando eles ao Twig e depois chamando-os nas views:<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><img src=\"https://albaweb.com.br/templates/site/assets/img/posts/677abd0f73369.png\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>Templates como o Twig não são a única forma de ter um sistema compartimentalizado, mas são recomendados, principalmente para aqueles que têm a necessidade de ter um HTML mais limpo, seja por ter uma equipe para cada lado da aplicação e/ou organização da arquitetura do software.<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>Referência:<span class=\"white-space-pre\" style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"> </span><a class=\"PvaypIWSSzaYekZGVDZTENtvQwtUaxUmatY \" target=\"_self\" href=\"https://twig.symfony.com/\" data-test-app-aware-link=\"\" style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); border: var(--artdeco-reset-link-border-zero); touch-action: manipulation; position: relative; word-break: normal; overflow-wrap: normal; line-height: inherit !important;\">https://twig.symfony.com/</a></p>', 'twig-e-suas-vantagens-no-projeto.png', 5, '2025-01-24 19:01:06', '2025-01-05 17:11:03', 1, 14, '2025-01-05 17:11:03', 'twig-e-suas-vantagens-no-projeto'),
(2, 'Não tenha medo de Soft Skills', '<p>Uma visão muito equivocada sobre Soft Skills é o pensamento de que são habilidades derivadas de um determinado tipo de personalidade ou temperamento. Esta visão deixa o tema ainda mais nebuloso e alguns podem acreditar ser impossível&nbsp; desenvolverem.<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>Soft Skills não são mais do que comportamentos que podem ser estudados e assimilados, independente das características e inclinações pessoais, mas como?<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>1° Modele outras pessoas: Veja como pessoas assertivas agem diante de situações desafiadoras e se inspire nesses exemplos para poder crescer. Da mesma forma, exemplos negativos são um aprendizado sobre o que não fazer;<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>2° Faça ensaios mentais: Pense nas diferentes formas de dizer e responder diante de uma crítica ou feedback negativo;<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>3° Avalie seu passado: Sua vida pregressa diz muito sobre seus pontos fortes e suas limitações, assim é possível saber exatamente o que é preciso melhorar e dedicar mais atenção;<span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span><span style=\"box-sizing: inherit; margin: var(--artdeco-reset-base-margin-zero); padding: var(--artdeco-reset-base-padding-zero); border: var(--artdeco-reset-base-border-zero); vertical-align: var(--artdeco-reset-base-vertical-align-baseline); outline: var(--artdeco-reset-base-outline-zero); line-height: inherit !important;\"><br style=\"box-sizing: inherit; line-height: inherit !important;\"></span>4° Mantenha tudo em uma agenda/diário: Todas essas coisas podem ser objeto de estudo, anote e repasse até aprender cada comportamento.</p>', 'nao-tenha-medo-de-soft-skills.png', 2, '2025-01-22 13:01:21', '2025-01-05 18:22:11', 1, 15, '2025-01-05 18:22:11', 'nao-tenha-medo-de-soft-skills'),
(61, 'Como a Experiência Alivia o Medo do Novo', '<p dir=\"ltr\" style=\"line-height:1.38;margin-top:0pt;margin-bottom:0pt;\"><span style=\"font-size:12pt;font-family:Arial,sans-serif;color:#000000;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Uma das coisas que a experiência na programação proporciona é a tranquilidade em ver tecnologias desconhecidas, o que antes era gatilho para a tal da “FOMO” (</span><span style=\"font-size:12pt;font-family:Arial,sans-serif;color:#000000;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">do inglês \"</span><span style=\"font-size:12pt;font-family:Arial,sans-serif;color:#000000;background-color:#ffffff;font-weight:400;font-style:italic;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">fear of missing out</span><span style=\"font-size:12pt;font-family:Arial,sans-serif;color:#000000;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">\"; \"o medo de perder algo”), agora é só mais uma tecnologia que você (ainda?) não conhece.</span></p><p><strong><br></strong></p><p dir=\"ltr\" style=\"line-height:1.38;margin-top:0pt;margin-bottom:0pt;\"><span style=\"font-size:12pt;font-family:Arial,sans-serif;color:#000000;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Isso acontece por entender que em programação as coisas não são tão diferentes assim, não há muita distância entre PHP, JavaScript ou C#, quer dizer, é claro que o paradigma, a sintaxe, filosofia ou forma de execução podem variar, mas a lógica é sempre a mesma, conceitos como “função”, “variáveis”, “matrizes”, etc., e até mesmo as estruturas de dados não foram reinventados desde Fortran apesar de óbvias evoluções.</span></p><p><strong><br></strong></p><p dir=\"ltr\" style=\"line-height:1.38;margin-top:0pt;margin-bottom:0pt;\"><span style=\"font-size:12pt;font-family:Arial,sans-serif;color:#000000;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Se você conhece algum Framework, mudam os termo, mas o uso e aplicação deles têm muito em comum, independente da arquitetura, sempre terá regra de negócio, alguma forma de interação com o banco e uma maneira de exibir dados na view. Configurações de ambiente de desenvolvimento, banco de dados e servidores, nada disso será tão inédito ao ponto de gerar a necessidade de partir do zero.</span></p><p><br></p><p dir=\"ltr\" style=\"line-height:1.38;margin-top:0pt;margin-bottom:0pt;\"><span style=\"font-size:12pt;font-family:Arial,sans-serif;color:#000000;background-color:#ffffff;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">É claro que isso não exclui a dedicação necessária para aprender novas tecnologias, isso sempre requererá muito estudo e trabalho (alias, estudo faz parte da rotina de quem trabalha com tecnologia), mas é inegável que os caminhos se tornam bem menos pedregosos.</span></p>', 'como-a-experiencia-na-alivia-o-medo-do-novo.png', 7, '2025-01-24 19:01:21', '2025-01-22 00:46:49', 1, 15, '2025-01-22 00:46:49', 'como-a-experiencia-alivia-o-medo-do-novo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(50) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `ultimo_login` datetime DEFAULT NULL,
  `cadastrado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `cpf`, `senha`, `status`, `ultimo_login`, `cadastrado_em`, `atualizado_em`) VALUES
(1, 'Ulisses Albardeiro', 'ualbardeiro@gmail.com', '37781649885', '$2y$10$/xLoGXYjHOWUq2zqgJTOG.X72/dlFCIxTQBORGiyk2EGZuQzYbxMm', 1, NULL, '2024-11-04 10:17:57', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria` (`categoria_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
