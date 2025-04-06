# Ulisses Albardeiro - Blog
# Produção: https://ulissesalbardeiro.com.br

Repositório blog pessoal. O projeto está configurado para rodar em ambiente local e produção, com rotas amigáveis utilizando `.htaccess`.

## Configuração

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
RewriteBase /caminho_para_o_projeto/

RewriteCond %{SCRIPT_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !-d
RewriteCond %{SCRIPT_FILENAME} !-l

RewriteRule ^(.*)$ index.php/$1
```
## Banco de Dados

O banco de dados pode ser restaurado a partir do arquivo `BD/blog.sql`. Para acessar o painel admin é necessário criar manualmente o usuário e senha diretamento na tabela 'usuários'