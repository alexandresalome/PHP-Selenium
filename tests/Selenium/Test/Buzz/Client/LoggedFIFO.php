<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium\Test\Buzz\Client;

use Buzz\Client\Mock\FIFO;
use Buzz\Message\Request;
use Buzz\Message\Response;

/**
 * Extends the FIFO client of Buzz to log the last request
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class LoggedFIFO extends FIFO
{
    /**
     * The last request executed
     *
     * @var Buzz\Message\Request
     */
    protected $lastRequest;

    /**
     * @inheritdoc
     */
    public function send(Request $request, Response $response)
    {
        $this->lastRequest = $request;

        parent::send($request, $response);
    }

    /**
     * Returns the last request.
     *
     * @return Buzz\Message\Request
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }
}
