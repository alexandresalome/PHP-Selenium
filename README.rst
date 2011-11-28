PHP Selenium Library
====================

This is still a work in progress.

Requirements
::::::::::::

* **PHP 5.3**
* **Buzz**: This library is using Buzz for communicating with Selenium Server.


Opening/Closing a session
:::::::::::::::::::::::::

::
    <?php
    // Create a new client
    $client  = new Selenium\Client('http://localhost:4444/wd/hub');

    // Create a session
    $session = $client->createSession(new Selenium\Capabilities('firefox'));

    // Close a session
    $session->close();

Session features
::::::::::::::::

::
    <?php

    // Get the source of the page
    $source = $session->getSource();

    // Screenshot (returns PNG data)
    $png = $session->screenshot();


Navigation features
:::::::::::::::::::

::
    <?php

    // Open an URL
    $session->navigation()->open('http://google.fr');

    // Get the current URL
    $url = $session->navigation()->getUrl();


Website sample
::::::::::::::

To main test suite is checking that the library correctly works (ie: calls to
the Selenium server are as expected). This test suite will not rely on any
Selenium server. To make some real tests, you can use the Website sample,
located in folder ``samples/website``. Please see the ``README.rst`` file
located in this folder for more informations.


References
::::::::::

* Selenium JSON Wire Protocol: http://code.google.com/p/selenium/wiki/JsonWireProtocol
