<?php
require_once __DIR__.'/../autoload.php';

$client  = new Selenium\Client('localhost', 4444);
$browser = $client->getBrowser('http://alexandre-salome.fr');

// Starts the browser
$browser->start();

$browser
    ->open('/')
    ->click(Selenium\Locator::linkContaining('Blog'))
    ->waitForPageToLoad(10000)
;

echo "Page title: ".$browser->getTitle()."\n";
