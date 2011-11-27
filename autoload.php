<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__.'/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();

$loader->registerNamespaces(array(
    'Symfony'  => __DIR__.'/vendor',
    'Buzz'     => __DIR__.'/vendor/buzz/lib',
    'Selenium' => array(__DIR__.'/src', __DIR__.'/tests', __DIR__.'/samples/website/tests')
));

$loader->register();
