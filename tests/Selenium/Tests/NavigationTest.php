<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium\Tests;

use Buzz\Client\Mock\FIFO;
use Buzz\Message\Response;

use Selenium\Navigation;
use Selenium\Client;
use Selenium\Session;

/**
 * Tests for the navigation object.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class NavigationTest extends \PHPUnit_Framework_TestCase
{
    protected $client;
    protected $buzzClient;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->buzzClient = new FIFO();
        $this->client     = new Client('http://localhost', $this->buzzClient);
        $this->session    = new Session($this->client, '12345');
        $this->navigation = new Navigation($this->session);
    }

    /**
     * Tests the open method of the navigation
     */
    public function testOpen()
    {
        $response = new Response();
        $response->addHeader('1.0 200 OK');
        $this->buzzClient->sendToQueue($response);

        $this->navigation->open('http://google.fr');

        $this->assertEquals(0, count($this->buzzClient->getQueue()));
    }

    /**
     * Tests the getUrl method of the session
     */
    public function testGetUrl()
    {
        $response = new Response();
        $response->addHeader('1.0 200 OK');
        $response->setContent(json_encode(array('value' => 'http://google.fr')));
        $this->buzzClient->sendToQueue($response);

        $url = $this->navigation->getUrl();

        $this->assertEquals('http://google.fr', $url);
        $this->assertEquals(0, count($this->buzzClient->getQueue()));
    }
}
