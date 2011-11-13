<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Selenium\Tests\Message;

use Selenium\Message\UrlGetRequest;

/**
 * Tests the request object for getting URL
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class UrlGetRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the basic case
     */
    public function testSimple()
    {
        $request = new UrlGetRequest('12345');

        $this->assertEquals('/session/12345/url', $request->getResource());
        $this->assertEquals('GET', $request->getMethod());
    }
}
