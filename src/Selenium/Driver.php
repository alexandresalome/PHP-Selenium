<?php

namespace Selenium;

/**
 * Driver for communication with Selenium server
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Driver
{
    /**
     * URL to the server
     *
     * @var string
     */
    protected $url;

    /**
     * Timeout of the server
     *
     * @var int
     */
    protected $timeout;

    /**
     * Current session ID
     *
     * @var string
     */
    protected $sessionId;

    /**
     * Instanciates the driver.
     *
     * @param string $url     The URL of the server
     * @param int    $timeout Timeout
     */
    public function __construct($url, $timeout)
    {
        $this->url     = $url;
        $this->timeout = $timeout;
    }

    /**
     * Starts a new session.
     *
     * @param string $type     Type of browser
     * @param string $startUrl Start URL for the browser
     */
    public function start($type = '*firefox', $startUrl = 'http://localhost')
    {
        if (null !== $this->sessionId) {
            throw new Exception("Session already started");
        }

        $response = $this->doExecute('getNewBrowserSession', $type, $startUrl);

        if (preg_match('/^OK,(.*)$/', $response, $vars)) {
            $this->sessionId = $vars[1];
        } else {
            throw new Exception("Invalid response from server : $response");
        }
    }

    /**
     * Executes an action
     *
     * @param string $command Command to run
     * @param string $target  Target
     * @param string $value   Value
     *
     * @return void
     */
    public function action($command, $target = null, $value = null)
    {
        $result = $this->doExecute($command, $target, $value);

        if ($result !== 'OK') {
            throw new Exception("Unexpected response from Selenium server : ".$result);
        }

    }

    public function getString($command, $target = null, $value = null)
    {
        $result = $this->doExecute($command, $target, $value);

        if (!preg_match('/^OK,(.*)/', $result, $vars)) {
            throw new Exception("Unexpected response from Selenium server : ".$result);
        }

        return $vars[1];
    }

    public function getStringArray($command, $target = null, $value = null)
    {
        $string = $this->getString($command, $target, $value);

        $result = array();

        $length  = strlen($string);
        $current = '';
        $skip    = false;

        for ($i = 0; $i < $length; $i++) {
            if (true === $skip) {
                $skip = false;
                continue;
            }

            $char = $string[$i];

            if ($char === '\\') {
                $skip = true;

                continue;
            }

            if ($char === ',') {
                $result[] = $current;
                $curent = '';

                continue;
            }
            $current .= $char;
        }

        return $result;
    }

    public function getNumber($command, $target = null, $value = null)
    {
        $string = $this->getString($command, $target, $value);

        return (int) $string;
    }

    public function getBoolean($command, $target = null, $value = null)
    {
        $string = $this->getString($command, $target, $value);

        return $string == 'true';
    }

    /**
     * Stops the session.
     *
     * @return void
     */
    public function stop()
    {
        if (null === $this->sessionId) {
            throw new Exception("Session not started");
        }

        $response = $this->doExecute('testComplete');
    }

    protected function doExecute($command, $target = null, $value = null)
    {
        $query = array('cmd' => $command);

        if ($target !== null) {
            $query[1] = $target;
        }

        if ($value !== null) {
            $query[2] = $value;
        }

        if (null !== $this->sessionId) {
            $query['sessionId'] = $this->sessionId;
        }

        $query = http_build_query($query);
        $url = $this->url.'?'.$query;

        $context = stream_context_create(array(
            'http' => array('timeout' => $this->timeout)
        ));

        $fp = @fopen($url, 'r', false, $context);

        if (false === $fp) {
            throw new Exception("Unable to connect ! ");
        }

        stream_set_blocking($fp, 1);
        stream_set_timeout($fp, $this->timeout);
        stream_socket_shutdown($fp, STREAM_SHUT_WR);

        $result = stream_get_contents($fp);

        fclose($fp);

        if (false === $result) {
            throw new Exception("Connection refused");
        }

        return $result;
    }
}
