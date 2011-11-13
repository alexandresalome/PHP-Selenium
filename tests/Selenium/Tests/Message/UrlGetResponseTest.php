<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Selenium\Tests\Message;

use Selenium\Message\UrlGetResponse;

/**
 * Tests the response object for getting URL
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class UrlGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the basic case
     */
    public function testSimple()
    {
        $response = new UrlGetResponse();
        $response->addHeader('1.0 200 OK');
        $response->setContent(json_encode(array('value' => 'http://google.fr')));

        $this->assertEquals('http://google.fr', $response->getUrl());
    }

    /**
     * Tests the error case
     */
    public function testError()
    {
        $response = new UrlGetResponse();
        $response->addHeader('1.0 500 Internal Error');

        try {
            $response->getUrl();
            $this->fail();
        } catch (\RuntimeException $e) {
            $this->assertEquals('The response code should be 200, response code from server was "500"', $e->getMessage());
        }
    }
}
