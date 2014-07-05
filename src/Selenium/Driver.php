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
     * Instantiates the driver.
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
     * @param string $command Command to execute
     * @param string $target  First parameter
     * @param string $value   Second parameter
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

    /**
     * Executes a command on the server and returns a string.
     *
     * @param string $command The command to execute
     * @param string $target  First parameter
     * @param string $value   Second parameter
     *
     * @return string The result of the command as a string
     */
    public function getString($command, $target = null, $value = null)
    {
        $result = $this->doExecute($command, $target, $value);

        if (!preg_match('/^OK,/', $result)) {
            throw new Exception("Unexpected response from Selenium server : ".$result);
        }

        return strlen($result) > 3 ? substr($result, 3) : '';
    }

    /**
     * Executes a command on the server and returns an array of string.
     *
     * @param string $command Command to execute
     * @param string $target  First parameter
     * @param string $value   Second parameter
     *
     * @return array The result of the command as an array of string
     */
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
                $current = '';

                continue;
            }
            $current .= $char;
        }

        return $result;
    }

    /**
     * Executes a command on the server and returns a number.
     *
     * @param string $command The command to execute
     * @param string $target  First parameter
     * @param string $value   Second parameter
     *
     * @return int The result of the command as a number
     */
    public function getNumber($command, $target = null, $value = null)
    {
        $string = $this->getString($command, $target, $value);

        return (int) $string;
    }

    /**
     * Executes a command on the server and returns a boolean.
     *
     * @param string $command The command to execute
     * @param string $target  First parameter
     * @param string $value   Second parameter
     *
     * @return boolean The result of the command as a boolean
     */
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

        $this->doExecute('testComplete');
        $this->sessionId = null;
    }

    /**
     * Executes a raw command on the server and integrate the current session
     * identifier if available.
     *
     * @param string $command Command to execute
     * @param string $target  First argument
     * @param string $value   Second argument
     *
     * @return string The raw result of the command
     */
    protected function doExecute($command, $target = null, $value = null)
    {
        $postFields = array();
        $query = array('cmd' => $command);

        if ($target !== null) {
            $postFields[1] = $target;
        }

        if ($value !== null) {
            $postFields[2] = $value;
        }

        if (null !== $this->sessionId) {
            $query['sessionId'] = $this->sessionId;
        }

        $query = http_build_query($query);
        $url = $this->url.'?'.$query;

        //open connection
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, count($postFields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        $curlErrno = curl_errno($ch);
        curl_close($ch);

        if ($curlErrno > 0) {
            throw new Exception("Unable to connect ! ");
        }

        if (false === $result) {
            throw new Exception("Connection refused");
        }

        return $result;
    }
}
