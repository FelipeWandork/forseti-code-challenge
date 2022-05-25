<?php

$limit = 0;

$content = file_get_contents("https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias?b_start:int=".$limit);

$dom = new domDocument();
@$dom->loadHTML($content);

$xpath  = new DOMXPath($dom);

$tagsA     = $xpath->query(".//a[@class='summary url']");
$tagsSpan  = $xpath->query(".//span[@class='summary-view-icon']");

foreach ($tagsA as $tagA) {

  $titles[] = $tagA->textContent;
  $links[]  = $tagA->attributes[1]->value;

}

$i = 0;
while ( $i < $tagsSpan->length){
    $dates[] = $tagsSpan[$i]->textContent;
    $i++;
    $hours[] = $tagsSpan[$i]->textContent;
    $i = $i + 2;
}
