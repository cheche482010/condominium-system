<?php

namespace App\Controllers;

class RouterController extends BaseController
{
   public function Api()
   {
      try {
         require __DIR__ . "/../Documentation/index.php";
      } catch (\Exception $e) {
         throw new \Exception('Error al cargar la vista: ' . $e->getMessage());
      }
   }
}
