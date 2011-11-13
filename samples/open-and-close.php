<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This sample will just open the browser and close it directly, without
 * performing any operation.
 */

require_once __DIR__.'/../autoload.php';

$client  = new Selenium\Client('http://localhost:4444/wd/hub');
$session = $client->createSession(new Selenium\Capabilities('firefox'));

$session->close();
