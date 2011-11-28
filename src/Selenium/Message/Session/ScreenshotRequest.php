<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium\Message\Session;

use Buzz\Message\Request;

/**
 * Request for a screenshot.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class ScreenshotRequest extends Request
{
    /**
     * Constructs the request object
     *
     * @param string $sessionId A session ID
     */
    public function __construct($sessionId)
    {
        parent::__construct(Request::METHOD_GET, sprintf('/session/%s/screenshot', $sessionId));
    }
}
