<?php
namespace app\model;

use app\model\TagsToDatabase;
use \PDO;
use \PDOStatement;
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

    $pages      = 5;
    $numberNews = 30;

    // Scraping do website - as 5 páginas foram percorridas
    for ( $limit = 0 ; $limit < ($pages * $numberNews) ; $limit += 30) {
      $this->loadDOM($limit);
      $this->loadDOMXPath($this->dom);
      $this->getElementsByClass($this->xpath);
      $this->toReadTags();
    }

    $this->toUpdateDatase();
  }


  public function toFillAll() {

      $tags = new TagsToDatabase;
      $tags->toSaveNews( array_reverse($this->titles), array_reverse($this->links), array_reverse($this->dates), array_reverse($this->hours) );

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

  public function toUpdateDatase(){

    $tagToDatabase = new TagsToDatabase;
    $titlesReverse = array_reverse($this->titles);

    foreach ($titlesReverse as $key => $title) {
      $i = array_search($title, $this->titles);

      $data = $tagToDatabase->checkDatabase($title)->fetch(PDO::FETCH_ASSOC);

      if (!$data) {
        $data['title'] = $title;
        $data['link']  = $this->links[$i];
        $data['date']  = trim($this->dates[$i]);
        $data['hour']  = trim($this->hours[$i]);

        $tagToDatabase->toUpdateNews($data['title'], $data['link'], $data['date'], $data['hour']);
      }
    }
  }
}
