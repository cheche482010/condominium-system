<?php

namespace App\Controllers;

class RouterController extends BaseController
{
   public function renderView($viewName)
   {
      try {
         require __DIR__ . "/../Views/{$viewName}/{$viewName}.php";
      } catch (\Exception $e) {
         throw new \Exception('Error al cargar la vista: ' . $e->getMessage());
      }
   }

   public function swgger()
   {
      try {
         require __DIR__ . "/../Documentation/index.php";
      } catch (\Exception $e) {
         throw new \Exception('Error al cargar la vista: ' . $e->getMessage());
      }
   }
}
