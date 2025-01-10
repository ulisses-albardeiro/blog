<?php

namespace sistema\Controlador\Admin;

use sistema\Modelos\CategoriaModelo;
use sistema\Modelos\PostModelo;
use sistema\Nucleo\Sessao;
use sistema\Nucleo\Helpers;

class AdminDashboard extends AdminControlador
{
   public function dashboard(): void
   {
      $visualizacoes = $this->visualizacoes();
      $posts_ativos = (new PostModelo())->busca('status = 1')->resultado(true);
      $posts_inativos = (new PostModelo())->busca('status = 0')->resultado(true);
      $total_categorias = (new CategoriaModelo())->busca()->resultado(true);

      echo $this->template->rendenizar('dashboard.html', [
         'visualizacoes' => $visualizacoes ?? null,
         'posts_ativos' => count($posts_ativos) ?? null,
         'posts_inativos' => isset($posts_inativos) ? count($posts_inativos) : 0,
         'total_categorias' => isset($total_categorias) ? count($total_categorias) : 0
      ]);
   }

   public function sair(): void
   {
      $sessao = new Sessao;
      $sessao->deletarSessao('usuarioId');

      Helpers::redirecionar('admin/login');
   }

   private function visualizacoes(): int
   {
      $visualizacoes = (new PostModelo())->busca()->resultado(true);

      if (!isset($visualizacoes->visitas)) {
         $contagem = 0;
         foreach ($visualizacoes as $value) {
            $contagem += $value->visitas;
         }
         return $contagem;
      } 


      return 0;
   }

}
