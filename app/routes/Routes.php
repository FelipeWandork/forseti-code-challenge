<?php
namespace app\routes;

use app\model\Scraping;

class Routes {
  public function scraping() {

    $scraping = new Scraping;

  }

  public function insertScraping() {
        require_once "app/model/insertScraping.php";
  }

  public function not_found() {
        require_once "app/view/not_found.html";
  }

}
