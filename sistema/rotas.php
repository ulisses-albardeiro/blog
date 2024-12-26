<?php

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Controlador\SiteControlador;
use sistema\Nucleo\Helpers;

try {
    SimpleRouter::setDefaultNamespace('sistema\Controlador');
    SimpleRouter::get(URL_SITE, 'SiteControlador@index');
    SimpleRouter::get(URL_SITE . 'contato', 'SiteControlador@contato');
    SimpleRouter::get(URL_SITE . 'post/{id}', 'SiteControlador@post');
    SimpleRouter::get(URL_SITE . 'categorias/{id}', 'SiteControlador@categorias');
    SimpleRouter::post(URL_SITE . 'pesquisa', 'SiteControlador@pesquisa');

    SimpleRouter::get(URL_SITE . '404', 'SiteControlador@erro404');

    //Grupo de Rotas para painel de controle do Site
    SimpleRouter::group(['namespace' => 'Admin'], function () {

        //Rota para a página de login do painel
        SimpleRouter::match(['get', 'post'], URL_ADMIN. 'login', 'AdminLogin@login');

        //Rota para o dashboard
        SimpleRouter::get(URL_ADMIN.'dashboard', 'AdminDashboard@dashboard');
        SimpleRouter::get(URL_ADMIN.'sair', 'AdminDashboard@sair');


        //Rotas Categorias
        SimpleRouter::get(URL_ADMIN.'categorias/listar', 'AdminCategorias@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN. 'categorias/cadastrar', 'AdminCategorias@cadastrarCategoria');
        SimpleRouter::match(['get', 'post'], URL_ADMIN. 'categorias/editar/{id}', 'AdminCategorias@editarCategoria');
        
        //Rotas Posts
        SimpleRouter::get(URL_ADMIN. 'posts/listar', 'AdminPosts@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN. 'posts/cadastrar', 'AdminPosts@cadastrarPost'); 
        SimpleRouter::match(['get', 'post'], URL_ADMIN. 'posts/editar/{id}', 'AdminPosts@editarPost');
        SimpleRouter::get(URL_ADMIN. 'posts/excluir/{id}', 'AdminPosts@excluirPost');
        SimpleRouter::get(URL_ADMIN. 'categorias/excluir/{id}', 'AdminCategorias@excluirCategoria');

        //Rotas Usuários
        SimpleRouter::get(URL_ADMIN. 'usuarios/listar', 'AdminUsuarios@usuarios');
        SimpleRouter::match(['get', 'post'], URL_ADMIN. 'usuario/cadastrar', 'AdminUsuarios@cadastrarUsuario'); 
        SimpleRouter::match(['get', 'post'], URL_ADMIN. 'usuario/editar/{id}', 'AdminUsuarios@editarUsuario');
        SimpleRouter::get(URL_ADMIN. 'usuario/excluir/{id}', 'AdminUsuarios@excluirUsuario');


    });

    SimpleRouter::start();
} catch (Exception $e) {

    if (Helpers::localhost()) {
        echo $e;
    } else {
        Helpers::redirecionar('404');
    }
    
}
