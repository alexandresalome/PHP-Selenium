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
 * Response message of screenshot request.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class ScreenshotResponse extends Response
{
    /**
     * Returns the content of screenshot response
     *
     * @return string The PNG file
     */
    public function getScreenshotData()
    {
        $statusCode = $this->getStatusCode();
        if ($statusCode !== 200) {
            throw new \RuntimeException(sprintf('The response code should be 200, response code from server was "%s"', $statusCode));
        }

        $content = str_replace("\0", "", $this->getContent());
        $content = json_decode($content, true);

        return base64_decode($content['value']);
    }
}
