<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium\Message;

use Buzz\Message\Request;

/**
 * Request for setting the current URL of the page
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class UrlSetRequest extends Request
{
    /**
     * Constructs the request object
     *
     * @param string $sessionId A session ID
     *
     * @param string $url A URL to set
     */
    public function __construct($sessionId, $url)
    {
        parent::__construct(Request::METHOD_POST, sprintf('/session/%s/url', $sessionId));

        $this->setContent(json_encode(array('url' => $url)));
    }
}
