<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium\Message\Navigation;

use Buzz\Message\Response;

/**
 * Response message of url getter.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class UrlGetResponse extends Response
{
    /**
     * Returns the session ID of the created session.
     *
     * @return string A session ID
     */
    public function getUrl()
    {
        $content = str_replace("\0", "", $this->getContent());
        $content = json_decode($content, true);

        return $content['value'];
    }
}
