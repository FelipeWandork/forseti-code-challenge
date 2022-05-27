<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\model\Scraping;

class ScrapingTest extends TestCase
{
    public function testLoadDOM()
    {
      $content = "https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias?b_start:int=0";
      $scraping = new Scraping;
      $this->expectNotNull($scraping->loadDOM($content));
    }

    public function testLoadDOMXPath()
    {
      $content  = "https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias?b_start:int=0";
      $document = new DOMDocument;
      $this->expectNotNull($scraping->loadDOMXPath($document));
    }
}
