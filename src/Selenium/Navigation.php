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
 * Navigation model for a session
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Navigation
{
    /**
     * The session to use
     *
     * @var Selenium\Session
     */
    protected $session;

    /**
     * Constructor.
     *
     * @param Selenium\Session The session to use
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Open a URL. The function will wait for page to load before returning the
     * value. If any redirection occurs, it will follow them before returning
     * a value.
     *
     * @param string $url A URL to access
     */
    public function open($url)
    {
        $sessionId = $this->session->getSessionId();
        $request   = new Message\Navigation\UrlSetRequest($sessionId, $url);
        $response  = new Response();

        $this->session->getClient()->process($request, $response);
    }

    /**
     * Returns the current session URL.
     *
     * @return string
     */
    public function getUrl()
    {
        $sessionId = $this->session->getSessionId();
        $request   = new Message\Navigation\UrlGetRequest($sessionId);
        $response  = new Message\Navigation\UrlGetResponse();

        $this->session->getClient()->process($request, $response);

        return $response->getUrl();
    }
}
