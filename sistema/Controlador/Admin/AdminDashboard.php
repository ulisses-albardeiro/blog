<?php

namespace sistema\Controlador\Admin;
use sistema\Nucleo\Sessao;
use sistema\Nucleo\Helpers;

class AdminDashboard extends AdminControlador
{
   public function dashboard():void
   {
    echo $this->template->rendenizar('dashboard.html', []);
   }

   public function sair(): void 
   {
      $sessao = new Sessao;
      $sessao->deletarSessao('usuarioId');

      Helpers::redirecionar('admin/login');
   }
}