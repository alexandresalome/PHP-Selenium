<?php

namespace Selenium;

/**
 * The base class of the browser.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class BaseBrowser
{
    /**
     * Driver to the server
     *
     * @var Selenium\Driver
     */
    protected $driver;

    /**
     * Start page of the browser
     *
     * @var string
     */
    protected $startPage;

    /**
     * Type of browser, for Selenium
     *
     * @var string
     */
    protected $type;

    /**
     * Instanciates a browser.
     *
     * @param Selenium\Driver $driver    Driver of the browser
     * @param string          $startPage The start page of the browser
     */
    public function __construct(Driver $driver, $startPage, $type = '*firefox')
    {
        $this->driver    = $driver;
        $this->startPage = $startPage;
        $this->type      = $type;
    }

    /**
     * Starts the browser on the server.
     *
     * @return Selenium\Browser Fluid interface
     */
    public function start()
    {
        $this->driver->start($this->type, $this->startPage);

        return $this;
    }

    /**
     * Stops the browser on the server.
     *
     * @return Selenium\Browser Fluid interface
     */
    public function stop()
    {
        $this->driver->stop();

        return $this;
    }
}
