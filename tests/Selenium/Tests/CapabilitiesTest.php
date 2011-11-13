<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium\Tests;

use Selenium\Capabilities;

/**
 * Tests for the capabilities object.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class CapabilitiesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the default behavior of the object.
     */
    public function testDefault()
    {
        $capabilities = new Capabilities('browser');

        $this->assertEquals('browser', $capabilities->browserName);
        $this->assertEquals('', $capabilities->version);

        $expected = array(
            'browserName'  => 'browser',
            'version'      => '',
            'platform'     => 'ANY'
        );

        $this->assertEquals($expected, $capabilities->toArray());
    }

    /**
     * Tests a basic compability setting.
     */
    public function testCapability()
    {
        $capabilities = new Capabilities('browser');
        $capabilities->takesScreenshot = true;

        $result = $capabilities->toArray();
        $this->assertArrayHasKey('takesScreenshot', $result);
        $this->assertEquals(true, $result['takesScreenshot']);
    }

    /**
     * Ensure the capability flags are correctly casted to boolean.
     */
    public function testBooleanCasting()
    {
        $capabilities = new Capabilities('browser');
        $capabilities->takesScreenshot = 'true';

        $result = $capabilities->toArray();
        $this->assertArrayHasKey('takesScreenshot', $result);
        $this->assertSame(true, $result['takesScreenshot']);
    }
}
