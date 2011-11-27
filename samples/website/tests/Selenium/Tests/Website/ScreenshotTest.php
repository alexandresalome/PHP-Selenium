<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium\Tests\Website;

use Selenium\Test\SeleniumTestCase;

/**
 * Verify the screenshot feature.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class ScreenshotTest extends SeleniumTestCase
{
    /**
     * Screenshots the page and make sure we have an image.
     */
    public function testBasic()
    {
        if (!class_exists('Imagick')) {
            $this->markTestSkipped('Imagick is not installed');
        }

        $session = $this->getSession();
        $session->open($this->getUrl('index.php'));

        $data = $session->screenshot();

        $image = new \Imagick();
        $image->readimageblob($data);

        $this->assertGreaterThan(100, $image->getImageWidth());
        $this->assertGreaterThan(100, $image->getImageHeight());
    }
}
