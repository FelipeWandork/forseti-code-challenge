<?php
namespace app\model;

use app\database\Database;
use \PDO;

class ReturnData {

  public function selectAll() {
    $where  = "";
    $order  = "";
    $limit  = "";
    $fields = "*";

    $db = new Database("noticias_compras");

    $statement = $db->select($where, $order, $limit, $fields);
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    $json = $this->objectToJson($data);

    return $data;

  }

  public function objectToJson($data) {
    $json = json_encode($data);
    return $json;
  }

  public function toPrintJson($json) {

    echo "<pre>";
    print_r($json);
    echo "</pre>";
  }

}
