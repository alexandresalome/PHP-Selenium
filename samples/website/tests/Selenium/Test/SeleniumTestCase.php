<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium\Test;

/**
 * Base class for functional testing of the website.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class SeleniumTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Selenium\Session
     */
    static protected $session;

    /**
     * Returns the unique session.
     *
     * @return Selenium\Session
     */
    public function getSession()
    {
        if (null === self::$session) {
            $client = new \Selenium\Client('http://localhost:4444/wd/hub');
            self::$session = $client->createSession(new \Selenium\Capabilities('firefox'));
        }

        return self::$session;
    }

    /**
     * Returns an URL for the website.
     *
     * @param string $file The file to get
     *
     * @return string The URL
     */
    public function getUrl($file)
    {
        return 'http://selenium.local/'.$file;
    }
}
