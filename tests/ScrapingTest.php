<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\model\Scraping;

class ScrapingTest extends TestCase
{
    public function testLoadDOM()
    {
        $scraping = new Scraping();
        $this->expectNotNull($scraping->loadDOM(150));
    }
}
