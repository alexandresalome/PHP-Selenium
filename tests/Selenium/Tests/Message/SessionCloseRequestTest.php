<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Selenium\Tests\Message;

use Selenium\Capabilities;
use Selenium\Message\SessionCloseRequest;

/**
 * Tests the request object for session closing.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class SessionCloseRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the basic case
     */
    public function testSimple()
    {
        $request = new SessionCloseRequest('12345');

        $this->assertEquals('/session/12345', $request->getResource());
        $this->assertEquals('DELETE', $request->getMethod());
    }
}
