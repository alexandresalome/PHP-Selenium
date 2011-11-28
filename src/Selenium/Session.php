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
     * The navigation manager
     *
     * @var Selenium\Navigation
     */
    protected $navigation;

    /**
     * Instanciates the object.
     *
     * @param string $sessionId The session ID
     *
     * @param Selenium\Client $client The client to use for exchanges with the
     * server
     */
    public function __construct(Client $client, $sessionId)
    {
        $this->client     = $client;
        $this->sessionId  = $sessionId;
        $this->navigation = new Navigation($this);
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
     * Returns the client associated to the
     * @return type
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Returns the navigation manager. Provides functionalities for navigating
     * like opening URLs, gettin URLs, refreshing page, history features, etc.
     *
     * @return Selenium\Navigation
     */
    public function navigation()
    {
        return $this->navigation;
    }

    /**
     * Captures a screenshot of the page, PNG format.
     *
     * @return string The PNG file content
     */
    public function screenshot()
    {
        $request  = new Message\Session\ScreenshotRequest($this->getSessionId());
        $response = new Message\Session\ScreenshotResponse();

        $this->client->process($request, $response);

        return $response->getScreenshotData();
    }

    /**
     * Requests the title of the current page.
     *
     * @return string The page title
     */
    public function getTitle()
    {
        $request  = new Message\Session\TitleRequest($this->getSessionId());
        $response = new Message\Session\TitleResponse();

        $this->client->process($request, $response);

        return $response->getTitle();
    }
}
