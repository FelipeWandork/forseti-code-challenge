<?php

$ch = curl_init();
$content = file_get_contents("https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias");


$dom = new domDocument();
@$dom->loadHTML($content);

$core = $dom->getElementById('content-core');
$article = $core->getElementsByTagName('article');

foreach ($article as $key => $value) {

  $div = $value->getElementsByTagName('div');
  $span  = $div[0]->getElementsByTagName('span');

  print_r( $span[textContent] );
}
