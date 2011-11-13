<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium\Message;

use Buzz\Message\Response;

/**
 * Response message of session creation.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class SessionCreateResponse extends Response
{
    /**
     * Returns the session ID of the created session.
     *
     * @return string A session ID
     */
    public function getSessionId()
    {
        $statusCode = $this->getStatusCode();
        if ($statusCode !== 302) {
            throw new \RuntimeException(sprintf('The response should be a redirection, response code from server was "%s"', $statusCode));
        }

        $location = $this->getHeader('Location');
        if (!preg_match('#/session/(\d+)$#', $location, $vars)) {
            throw new \RuntimeException(sprintf('The Location should end with /session/<session-id> (location returned: %s)', $location));
        }

        return $vars[1];
    }
}
