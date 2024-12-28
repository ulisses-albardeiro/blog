<?php

require 'vendor/autoload.php';
//require 'sistema/rotas.php';

use sistema\Biblioteca\Upload;

$up = new Upload('dirUpload');

$arquivo = ($_FILES['arquivo']);


$up->arquivo($arquivo, null, 'img');


echo '<pre>';
var_dump($up);
echo '<pre>';
?>


<form enctype="multipart/form-data" method="post">
    <input type="file" name="arquivo">
    <button>enviar</button>
</form>