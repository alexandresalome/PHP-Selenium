<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium\Message\Session;

use Buzz\Message\Response;

/**
 * Response message of title request.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class TitleResponse extends Response
{
    /**
     * Returns the title.
     *
     * @return string A page title
     */
    public function getTitle()
    {
        $content = str_replace("\0", "", $this->getContent());
        $content = json_decode($content, true);

        return $content['value'];
    }
}
