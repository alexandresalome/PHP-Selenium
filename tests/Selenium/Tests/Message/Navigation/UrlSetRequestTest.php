<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Selenium\Tests\Message\Navigation;

use Selenium\Message\Navigation\UrlSetRequest;

/**
 * Tests the request object for setting URL
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class UrlSetRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the basic case
     */
    public function testSimple()
    {
        $request = new UrlSetRequest('12345', 'http://google.fr');

        $data = $request->getContent();
        $data = json_decode($data, true);

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/session/12345/url', $request->getResource());
        $this->assertEquals(array('url' => 'http://google.fr'), $data);
    }
}
