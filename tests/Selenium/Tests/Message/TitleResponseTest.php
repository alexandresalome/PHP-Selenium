<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Selenium\Tests\Message;

use Selenium\Message\TitleResponse;

/**
 * Tests the response object for getting title
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class TitleResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the basic case
     */
    public function testSimple()
    {
        $response = new TitleResponse();
        $response->addHeader('1.0 200 OK');
        $response->setContent(json_encode(array('value' => "foo")));

        $this->assertEquals('foo', $response->getTitle());
    }
}
