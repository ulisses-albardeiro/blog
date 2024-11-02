<?php

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Controlador\SiteControlador;
use sistema\Nucleo\Helpers;

try {
    SimpleRouter::setDefaultNamespace('sistema\Controlador');
    SimpleRouter::get(URL_SITE, 'SiteControlador@index');
    SimpleRouter::get(URL_SITE . 'sobre', 'SiteControlador@sobre');
    SimpleRouter::get(URL_SITE . 'post/{id}', 'SiteControlador@post');
    SimpleRouter::get(URL_SITE . 'categorias/{id}', 'SiteControlador@categorias');
    SimpleRouter::post(URL_SITE . 'pesquisa', 'SiteControlador@pesquisa');

    SimpleRouter::get(URL_SITE . '404', 'SiteControlador@erro404');

    //Grupo de Rotas para painel de controle do Site
    SimpleRouter::group(['namespace' => 'Admin'], function () {
        SimpleRouter::get(URL_ADMIN.'dashboard', 'AdminDashboard@dashboard');

        //Rotas Categorias
        SimpleRouter::get(URL_ADMIN.'categorias/listar', 'AdminCategorias@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN. 'categorias/cadastrar', 'AdminCategorias@cadastrarCategoria');



        SimpleRouter::match(['get', 'post'], URL_ADMIN. 'categorias/editar/{id}', 'AdminCategorias@editarCategoria');



        
        //Rotas Posts
        SimpleRouter::get(URL_ADMIN. 'posts/listar', 'AdminPosts@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN. 'posts/cadastrar', 'AdminPosts@cadastrarPost'); 
        SimpleRouter::match(['get', 'post'], URL_ADMIN. 'posts/editar/{id}', 'AdminPosts@editarPost');


    });

    SimpleRouter::start();
} catch (Exception $e) {

    if (Helpers::localhost()) {
        echo $e;
    } else {
        Helpers::redirecionar('404');
    }
}
