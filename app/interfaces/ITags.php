<?php
namespace app\interfaces;

interface ITags {

  public function toSaveNews( $titles, $links, $dates, $hours );
}
