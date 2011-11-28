<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Selenium\Tests\Message\Session;

use Selenium\Message\Session\SourceRequest;

/**
 * Tests the request object for source code
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class SourceRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the basic case
     */
    public function testSimple()
    {
        $request = new SourceRequest('12345');

        $this->assertEquals('/session/12345/source', $request->getResource());
        $this->assertEquals('GET', $request->getMethod());
    }
}
