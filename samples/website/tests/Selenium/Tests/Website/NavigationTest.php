<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium\Tests\Website;

use Selenium\Test\SeleniumTestCase;

/**
 * Verify the navigation features of the session.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class NavigationTest extends SeleniumTestCase
{
    /**
     * Tests URL getter and setter.
     */
    public function testUrl()
    {
        $url = $this->getUrl('index.php');

        $session = $this->getSession();
        $session->navigation()->open($url);

        $this->assertEquals($url, $session->navigation()->getUrl());
    }
}
