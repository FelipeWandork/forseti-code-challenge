<?php
namespace app\model;

use app\model\Uuid;
use app\database\Database;
use app\interfaces\ITags;

class TagsToDatabase implements ITags {

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


}
