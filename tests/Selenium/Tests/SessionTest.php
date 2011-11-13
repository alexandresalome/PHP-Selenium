<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium\Tests;

use Selenium\Session;

/**
 * Tests for the session object.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class SessionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Mock client for creating sessions
     *
     * @var Selenium\Client
     */
    protected $client;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->client = $this->getMock('Selenium\Client', array(
            'closeSession'
        ), array(
           'http://localhost'
        ));
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
        $this->client
            ->expects($this->once())
            ->method('closeSession')
            ->with($this->equalTo('12345'))
        ;

        $session = new Session('12345', $this->client);

        $session->close();

        $this->assertNull($session->getSessionId());
    }
}
