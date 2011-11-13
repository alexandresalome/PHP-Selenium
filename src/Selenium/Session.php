<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium;

/**
 * WebDriver Session
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Session
{
    /**
     * The session ID on the current server
     *
     * @var string
     */
    protected $sessionId;

    /**
     * The WebDriver server
     *
     * @var Selenium\Client
     */
    protected $client;

    /**
     * Instanciates the object.
     *
     * @param string $sessionId The session ID
     *
     * @param Selenium\Client $client The client to use for exchanges with the
     * server
     */
    public function __construct($sessionId, Client $client)
    {
        $this->sessionId = $sessionId;
        $this->client    = $client;
    }

    /**
     * Returns the current session ID.
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }
}
