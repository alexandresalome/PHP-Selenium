<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Selenium\Tests\Message\Session;

use Selenium\Message\Session\TitleRequest;

/**
 * Tests the request object for getting title
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class TitleRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the basic case
     */
    public function testSimple()
    {
        $request = new TitleRequest('12345');

        $this->assertEquals('/session/12345/title', $request->getResource());
        $this->assertEquals('GET', $request->getMethod());
    }
}
