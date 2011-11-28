<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Selenium\Tests\Message\Session;

use Selenium\Message\Session\ScreenshotResponse;

/**
 * Tests the response object for screenshot
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class ScreenshotResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the basic case
     */
    public function testSimple()
    {
        $response = new ScreenshotResponse();
        $response->addHeader('1.0 200 OK');
        $response->setContent(json_encode(array('value' => base64_encode('foo'))));

        $this->assertEquals('foo', $response->getScreenshotData());
    }
}
