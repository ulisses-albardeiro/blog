# Ulisses Albardeiro - Blog Pessoal

Blog pessoal desenvolvido em PHP com sistema de administração. O projeto está configurado para rodar em ambiente local e produção, com rotas amigáveis utilizando `.htaccess`.

**URL de produção:** https://ulissesalbardeiro.com.br

## Requisitos
- PHP 8.2+
- MySQL 5.7+
- Composer (para dependências)

## Instalação

1. Clone o repositório
2. Crie os arquivos 'config.php' e 'htaccess' (veja as seções arquivo)
3. Configure o banco de dados (veja seção Banco de Dados)
4. Instale as dependências:

```bash
composer install
```

### Arquivo `config.php`

```php
date_default_timezone_set('America/Sao_Paulo');

define('DB_NOME', 'nome_do_banco');
define('DB_HOST', 'nome_do_host');
define('DB_USUARIO', 'usuario_do_banco');
define('DB_SENHA', 'senha_do_banco');

define('SITE_NAME', '');
define('SITE_DESC', '');

define('PRODUCTION_URL', 'https://seu_site.com.br');
define('DEVELOPMENT_URL', 'http://localhost/caminho_para_o_projeto/');

define('URL_SITE', '/caminho_para_o_projeto/');
define('URL_ADMIN','/admin/');
```


### Arquivo `htaccess`

```
Options -Indexes

RewriteEngine on

#ambiente de produção (descomentar)
#RewriteBase /

#ambiente de desenvolvimento (descomentar)
#RewriteBase /caminho_para_o_projeto/

RewriteCond %{SCRIPT_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !-d
RewriteCond %{SCRIPT_FILENAME} !-l

RewriteRule ^(.*)$ index.php/$1
```


## Banco de Dados

O banco de dados pode ser restaurado a partir do arquivo `BD/blog.sql`. Para acessar o painel admin é necessário criar manualmente o usuário e senha diretamento na tabela 'usuários'.