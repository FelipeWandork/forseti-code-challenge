<?php
namespace app\model;

use app\model\Uuid;
use app\database\Database;
use app\interfaces\ITags;

class TagsToDatabase implements ITags {

  public function checkDatabase($title) { // verificar se banco já contem notícias e qual a última

    $where  = " title LIKE '". addslashes($title)."'";
    $order  = "";
    $limit  = "";
    $fields = "*";

    $statement = $this->select($where, $order, $limit, $fields);
    return $statement;
  }

  public function selectNews() {
    $where  = "";
    $order  = "";
    $limit  = "";
    $fields = "*";

    $statement = $this->select($where, $order, $limit, $fields);
    return $statement;
  }

  public function select( $where, $order, $limit, $fields ){

    $db = new Database("noticias_compras");
    $statement = $db->select($where, $order, $limit, $fields);

    return $statement;
  }

  public function toSaveNews( $titles, $links, $dates, $hours ) {

    for( $i = 0 ; $i < count($titles) ; $i++ ) {

      $v4_uuid = new Uuid;
      $uuid    = $v4_uuid->v4_UUID();

      $db = new Database("noticias_compras");

      $db->insert([
        "uuid"   => $uuid,
        "title"  => $titles[$i],
        "link"   => $links[$i],
        "date"   => trim($dates[$i]),
        "hour"   => trim($hours[$i])
      ]);
    }
  }

  public function toUpdateNews( $titles, $links, $dates, $hours ) {
    $v4_uuid = new Uuid;
    $uuid    = $v4_uuid->v4_UUID();

    $db = new Database("noticias_compras");
    $db->insert([
      "uuid"  => $uuid,
      "title" => $titles,
      "link"  => $links,
      "date"  => $dates,
      "hour"  => $hours
    ]);
  }
}
