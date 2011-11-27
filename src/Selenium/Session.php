<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium;

use Buzz\Message\Response;

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
     * Closes the session and disable this session.
     */
    public function close()
    {
        $this->client->closeSession($this->getSessionId());
        $this->sessionId = null;
    }

    /**
     * Returns the current session ID.
     *
     * @return string
     */
    public function getSessionId()
    {
        if (null === $this->sessionId) {
            throw new \RuntimeException('This session was closed');
        }

        return $this->sessionId;
    }

    /**
     * Returns the current session URL.
     *
     * @return string
     */
    public function getUrl()
    {
        $request  = new Message\UrlGetRequest($this->getSessionId());
        $response = new Message\UrlGetResponse();

        $this->client->process($request, $response);

        return $response->getUrl();
    }

    /**
     * Open a URL. The function will wait for page to load before returning the
     * value. If any redirection occurs, it will follow them before returning
     * a value.
     *
     * @param string $url A URL to access
     *
     * @return Selenium\Session fluid interface
     */
    public function open($url)
    {
        $request  = new Message\UrlSetRequest($this->getSessionId(), $url);
        $response = new Response();

        $this->client->process($request, $response);

        return $this;
    }

    /**
     * Captures a screenshot of the page, PNG format.
     *
     * @return string The PNG file content
     */
    public function screenshot()
    {
        $request = new Message\ScreenshotRequest($this->getSessionId());
        $response = new Message\ScreenshotResponse();

        $this->client->process($request, $response);

        return $response->getScreenshotData();
    }
}
