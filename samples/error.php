<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This sample shows the error message when asking a browser with a float value
 */

require_once __DIR__.'/../autoload.php';

$client  = new Selenium\Client('http://localhost:4444/wd/hub');
$capabilities = new Selenium\Capabilities(2000);

try {
    $session = $client->createSession($capabilities);
} catch (\RuntimeException $e) {
    echo sprintf("Error message: %s\n", $e->getMessage());
}
