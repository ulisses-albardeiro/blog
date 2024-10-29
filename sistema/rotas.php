<?php

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Controlador\SiteControlador;
use sistema\Nucleo\Helpers;

try {
    SimpleRouter::setDefaultNamespace('sistema\Controlador');
    SimpleRouter::get(URL_SITE, 'SiteControlador@index');
    SimpleRouter::get(URL_SITE . 'sobre', 'SiteControlador@sobre');
    SimpleRouter::get(URL_SITE . '404', 'SiteControlador@erro404');
    SimpleRouter::get(URL_SITE . 'post/{id}', 'SiteControlador@post');
    SimpleRouter::get(URL_SITE . 'categorias/{id}', 'SiteControlador@categorias');
    SimpleRouter::start();
} catch (Exception $e) {

    if (Helpers::localhost()) {
        echo $e;
    } else {
        Helpers::redirecionar('404');
    }
}
