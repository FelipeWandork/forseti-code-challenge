<?php
namespace app\model;

use app\model\TagsToDatabase;
use \DOMDocument;
use \DOMXPath;

class Scraping {
  private $website = "https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias?b_start:int=";
  private $dom;
  private $xpath;
  private $tagsA;
  private $tasSpan;
  private $titles;
  private $links;
  private $dates;
  private $hours;

  public function __construct() {

    for ( $limit   = 0 ; $limit <= 120 ; $limit += 30) {

      $this->loadDOM($limit);
      $this->loadDOMXPath($this->dom);
      $this->getElementsByClass($this->xpath);
      $this->toReadTags();

    }

    $tags = new TagsToDatabase;
    $tags->toSaveNews($this->titles, $this->links, $this->dates, $this->hours );

  }

  public function loadDOM($limit) {

    $content = file_get_contents($this->website . $limit);

    $document = new DOMDocument();

    @$document->loadHTML($content);

    $this->dom = $document;

  }

  public function loadDOMXPath($dom) {

    $this->xpath  = new DOMXPath($dom);

  }


  public function getElementsByClass($xpath) {

    $this->tagsA     = $xpath->query(".//a[@class='summary url']");
    $this->tagsSpan  = $xpath->query(".//span[@class='summary-view-icon']");

  }

  public function toReadTags() {

      foreach ($this->tagsA as $tag) {

        $this->titles[] = $tag->textContent;
        $this->links[]  = $tag->attributes[1]->value;

      }

      $i = 0;
      while ( $i < $this->tagsSpan->length) {
          $this->dates[] = $this->tagsSpan[$i]->textContent;
          $i++;
          $this->hours[] = $this->tagsSpan[$i]->textContent;
          $i = $i + 2;
      }
  }

}
