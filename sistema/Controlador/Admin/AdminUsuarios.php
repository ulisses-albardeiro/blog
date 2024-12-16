<?php

namespace sistema\Controlador\Admin;

class AdminUsuarios extends AdminControlador
{
    public function usuarios()
    {
        echo $this->template->rendenizar('usuarios/listar.html',[]);
    }
}