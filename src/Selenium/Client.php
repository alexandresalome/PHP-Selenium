<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium;

use Buzz\Client\Curl;
use Buzz\Client\ClientInterface;
use Buzz\Message\Request;
use Buzz\Message\Response;

/**
 * Client for a WebDriver server.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Client
{
    /**
     * Default timeout for CURL connections
     */
    const DEFAULT_TIMEOUT = 20000;

    /**
     * The base URL for WebDriver server.
     *
     * @var string
     */
    protected $url;

    /**
     * The Buzz client to use for requesting the service.
     *
     * @var Buzz\Client\ClientInterface
     */
    protected $client;

    /**
     * Associative array containing all existing sessions
     *
     * @var array
     */
    protected $sessions;

    /**
     * Constructs the client.
     *
     * @param string $url The base URL for WebDriver server
     *
     * @param Buzz\Client\ClientInterface $client The client to use for
     * requesting the WebDriver server
     */
    public function __construct($url, ClientInterface $client = null)
    {
        if (null === $client) {
            $client = new Curl();
            $client->setTimeout(self::DEFAULT_TIMEOUT);
            $client->setMaxRedirects(0);
        }

        $this->url    = $url;
        $this->client = $client;
    }

    /**
     * Creates a new session from desired capabilities.
     *
     * @param Selenium\Capabilities $capabilities Capabilities to request to
     * the server
     *
     * @return Selenium\Session The instanciated session ready to be used
     */
    public function createSession(Capabilities $capabilities)
    {
        $request  = new Message\Client\SessionCreateRequest($capabilities);
        $response = new Message\Client\SessionCreateResponse();

        $this->process($request, $response);

        $sessionId = $response->getSessionId();

        return $this->sessions[$sessionId] = new Session($this, $sessionId);
    }

    /**
     * Returns a session according to his ID. To get it, it must first have
     * been created.
     *
     * @param string $sessionId The session ID to fetch
     *
     * @return Selenium\Session The session associated
     *
     * @throws RuntimeException An exception is thrown if the session does not
     * exists.
     */
    public function getSession($sessionId)
    {
        if (!isset($this->sessions[$sessionId])) {
            throw new \RuntimeException(sprintf('The session "%s" was not found', $sessionId));
        }

        return $this->sessions[$sessionId];
    }

    /**
     * Closes a session according to his ID.
     *
     * @param string $sessionId A session ID
     */
    public function closeSession($sessionId)
    {
        $request = new Message\Client\SessionCloseRequest($sessionId);
        $response = new Response();

        $this->process($request, $response);

        unset($this->sessions[$sessionId]);
    }

    /**
     * Plumber method to request the server, using the base URL.
     *
     * @param Buzz\Message\Request $request The request to send
     *
     * @param Buzz\Message\Response $response The response to fill
     */
    public function process(Request $request, Response $response)
    {
        $url = $this->url.$request->getResource();

        $newRequest = clone $request;
        $newRequest->fromUrl($url);

        $newResponse = new Response();

        $this->client->send($newRequest, $newResponse);

        $this->verifyResponse($newResponse);

        $response->setHeaders($newResponse->getHeaders());
        $response->setContent($newResponse->getContent());
    }

    /**
     * Verifies every response received from the server to make sure no error
     * happened during processing.
     *
     * @param Buzz\Message\Response A response object to verify
     */
    protected function verifyResponse(Response $response)
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode === 200 || $statusCode === 204 || ($statusCode >= 300 && $statusCode <= 303)) {
            return;
        }

        $errorResponse = new Message\ErrorResponse();
        $errorResponse->setHeaders($response->getHeaders());
        $errorResponse->setContent($response->getContent());

        throw $errorResponse->getException();
    }
}
