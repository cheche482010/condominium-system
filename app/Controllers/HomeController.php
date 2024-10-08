<?php

namespace App\Controllers;

class HomeController extends BaseController
{
   public function index()
   {
      require __DIR__ . "/../Views/home/home.php";
   }
}
