<?php
namespace app\controller;

use app\interfaces\INavController;
use app\routes\Routes;



class NavController implements INavController {
  const HOST = "localhost";

  public function __construct(){
    $host = $_SERVER["HTTP_HOST"];
    $url  = $_SERVER["REQUEST_URI"];

//    $pg = explode("/", $url);

    self::URLController($host, $url);
  }


  public function URLController( $host, $url ) {
    if($host !== self::HOST){
      $page = "not_found.html";
      self::PageController($page);
    }
    $page = $url;
    self::PageController($page);
  }


	public function PageController( $page ) {
    $route = new Routes;
    $route->home();
  } // direciona para a rota requisitada

}
