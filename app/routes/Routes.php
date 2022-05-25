<?php
namespace app\routes;

class Routes {
  public function home() {
        require_once "app/view/home.php";
  }

  public function not_found() {
        require_once "app/view/not_found.html";
  }

}
