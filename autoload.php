<?php

require_once __DIR__.'/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';
require_once __DIR__.'/vendor/Symfony/Component/ClassLoader/DebugUniversalClassLoader.php';

$classLoader = new Symfony\Component\ClassLoader\DebugUniversalClassLoader();
$classLoader->register();

$classLoader->registerNamespace('Selenium', __DIR__.'/src');
$classLoader->registerNamespace('Symfony', __DIR__.'/vendor');
$classLoader->registerPrefix('PHPParser', __DIR__.'/vendor/php-parser/lib');
