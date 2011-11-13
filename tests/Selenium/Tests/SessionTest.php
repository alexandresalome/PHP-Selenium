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

use Selenium\Session;
use Selenium\Client;

/**
 * Tests for the session object.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class SessionTest extends \PHPUnit_Framework_TestCase
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
    }

    /**
     * Tests the getSessionId method.
     */
    public function testGetSessionId()
    {
        $session = new Session('12345', $this->client);

        $this->assertEquals('12345', $session->getSessionId());
    }

    /**
     * Tests the close method.
     */
    public function testClose()
    {
        $this->buzzClient->sendToQueue(new Response());

        $session = new Session('12345', $this->client);

        $session->close();

        try {
            $session->getSessionId();
            $this->fail();
        } catch (\RuntimeException $e) {
            $this->assertEquals('This session was closed', $e->getMessage());
        }
    }

    /**
     * Tests the open method of the session
     */
    public function testOpen()
    {
        $response = new Response();
        $this->buzzClient->sendToQueue($response);

        $session = new Session('12345', $this->client);

        $session = $session->open('http://google.fr');

        $this->assertInstanceOf('Selenium\Session', $session);
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

        $session = new Session('12345', $this->client);

        $url = $session->getUrl();

        $this->assertEquals('http://google.fr', $url);
        $this->assertEquals(0, count($this->buzzClient->getQueue()));
    }
}
