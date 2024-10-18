<?php

namespace App\Controllers;

class HomeController extends BaseController
{
   public function renderView($viewName)
   {
      #$this->handleIsUserLoggedIn(); // verificacion de usuarlio loggeado

      try {
         require __DIR__ . "/../Views/{$viewName}/{$viewName}.php";
      } catch (\Exception $e) {
         throw new \Exception('Error al cargar la vista: ' . $e->getMessage());
      }
   }
}
