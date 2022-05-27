<?php
namespace app\interfaces;

interface ITags {

  public function toSaveNews( $titles, $links, $dates, $hours );

  public function toUpdateNews( $titles, $links, $dates, $hours );

  public function select( $where, $order, $limit, $fields );

}
