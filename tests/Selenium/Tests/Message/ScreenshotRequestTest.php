<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Selenium\Tests\Message;

use Selenium\Message\ScreenshotRequest;

/**
 * Tests the request object for screenshot
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class ScreenshotRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the basic case
     */
    public function testSimple()
    {
        $request = new ScreenshotRequest('12345');

        $this->assertEquals('/session/12345/screenshot', $request->getResource());
        $this->assertEquals('GET', $request->getMethod());
    }
}
