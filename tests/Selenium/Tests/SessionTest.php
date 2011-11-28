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
        $this->session    = new Session($this->client, '12345');
    }

    /**
     * Tests the getSessionId method.
     */
    public function testGetSessionId()
    {

        $this->assertEquals('12345', $this->session->getSessionId());
    }

    /**
     * Tests the close method.
     */
    public function testClose()
    {
        $response = new Response();
        $response->addHeader('1.0 200 OK');
        $this->buzzClient->sendToQueue($response);

        $this->session->close();

        try {
            $this->session->getSessionId();
            $this->fail();
        } catch (\RuntimeException $e) {
            $this->assertEquals('This session was closed', $e->getMessage());
        }
    }

    public function testScreenshot()
    {
        $response = new Response();
        $response->addHeader('1.0 200 OK');
        $response->setContent(json_encode(array('value' => base64_encode('foo'))));
        $this->buzzClient->sendToQueue($response);

        $data = $this->session->screenshot();

        $this->assertEquals('foo', $data);
        $this->assertEquals(0, count($this->buzzClient->getQueue()));
    }

    public function testGetSource()
    {
        $response = new Response();
        $response->addHeader('1.0 200 OK');
        $response->setContent(json_encode(array('value' => 'foo')));
        $this->buzzClient->sendToQueue($response);

        $data = $this->session->getSource();

        $this->assertEquals('foo', $data);
        $this->assertEquals(0, count($this->buzzClient->getQueue()));
    }

    public function testGetTitle()
    {
        $response = new Response();
        $response->addHeader('1.0 200 OK');
        $response->setContent(json_encode(array('value' => "foo")));
        $this->buzzClient->sendToQueue($response);

        $data = $this->session->getTitle();

        $this->assertEquals('foo', $data);
        $this->assertEquals(0, count($this->buzzClient->getQueue()));
    }

    public function testNavigation()
    {
        $navigation = $this->session->navigation();

        $this->assertInstanceOf('Selenium\Navigation', $navigation);
    }
}
