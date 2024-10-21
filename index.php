<?php

require 'vendor/autoload.php';
require 'sistema/rotas.php';

use sistema\Modelos\PostModelo;

$posts = (new PostModelo())->ler(1);

foreach($posts as $post){

    echo $post['titulo'].'<br>';
}

