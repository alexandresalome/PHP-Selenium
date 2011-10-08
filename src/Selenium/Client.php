<?php

namespace Selenium;

/**
 * Client for the Selenium Server.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Client
{
    /**
     * Host of the Selenium Server
     *
     * @var string
     */
    protected $host;

    /**
     * Port of the Selenium Server
     *
     * @var string
     */
    protected $port;

    /**
     * Timeout for the server
     *
     * @var int
     */
    protected $timeout;

    /**
     * Instanciates the client.
     *
     * @param string $host    Host of the server
     * @param int    $port    Port of the server
     * @param int    $timeout Timeout of the server
     */
    public function __construct($host = 'localhost', $port = 4444, $timeout = 60)
    {
        $this->host    = $host;
        $this->port    = $port;
        $this->timeout = $timeout;
    }

    /**
     * Creates a new browser instance.
     *
     * @param string $startPage The URL of the website to test
     * @param string $type      Type of browser, for Selenium
     *
     * @return Selenium\Browser A browser instance
     */
    public function getBrowser($startPage, $type = '*firefox')
    {
        $url = 'http://'.$this->host.':'.$this->port.'/selenium-server/driver/';
        $driver = new Driver($url, $this->timeout);

        return new Browser($driver, $startPage, $type);
    }
}
