<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Selenium;

/**
 * Representation of a browser capabilities.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class Capabilities
{
    /**
     * The name of the browser being used; should be one of
     * {chrome|firefox|htmlunit|internet explorer|iphone}.
     *
     * @var string
     */
    public $browserName;

    /**
     * The browser version, or the empty string if unknown.
     *
     * @var string
     */
    public $version = '';

    /**
     * A key specifying which platform the browser is running on. This value
     * should be one of {WINDOWS|XP|VISTA|MAC|LINUX|UNIX}. When requesting a new
     * session, the client may specify ANY to indicate any available platform
     * may be used.
     *
     * @var string
     */
    public $platform = 'ANY';

    /**
     * Whether the session supports executing user supplied JavaScript in the
     * context of the current page.
     *
     * @var boolean
     */
    public $javascriptEnabled;

    /**
     * Whether the session supports taking screenshots of the current page.
     *
     * @var boolean
     */
    public $takesScreenshot;

    /**
     * Whether the session can interact with modal popups, such as window.alert and window.confirm.
     *
     * @var boolean
     */
    public $handlesAlerts;

    /**
     * Whether the session can interact database storage.
     *
     * @var boolean
     */
    public $databaseEnabled;

    /**
     * Whether the session can set and query the browser's location context.
     *
     * @var boolean
     */
    public $locationContextEnabled;

    /**
     * Whether the session can interact with the application cache.
     *
     * @var boolean
     */
    public $applicationCacheEnabled;

    /**
     * Whether the session can query for the browser's connectivity and disable
     * it if desired.
     *
     * @var boolean
     */
    public $browserConnectionEnabled;

    /**
     * Whether the session supports CSS selectors when searching for elements.
     *
     * @var boolean
     */
    public $cssSelectorsEnabled;

    /**
     * Whether the session supports interactions with storage objects.
     *
     * @var boolean
     */
    public $webStorageEnabled;

    /**
     * Whether the session can rotate the current page's current layout between
     * portrait and landscape orientations (only applies to mobile platforms).
     *
     * @var boolean
     */
    public $rotatable;

    /**
     * Whether the session should accept all SSL certs by default.
     *
     * @var boolean
     */
    public $acceptSslCerts;

    /**
     * Whether the session is capable of generating native events when
     * simulating user input.
     *
     * @var boolean
     */
    public $nativeEvents;

    public function __construct($browserName)
    {
        $this->browserName = $browserName;
    }

    /**
     * Converts the object to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $result = array(
            'browserName' => $this->browserName,
            'version'     => $this->version,
            'platform'    => $this->platform
        );

        $capacityFlags = array(
            'javascriptEnabled',
            'takesScreenshot',
            'handlesAlerts',
            'databaseEnabled',
            'locationContextEnabled',
            'applicationCacheEnabled',
            'browserConnectionEnabled',
            'cssSelectorsEnabled',
            'webStorageEnabled',
            'rotatable',
            'acceptSslCerts',
            'nativeEvents'
        );

        foreach ($capacityFlags as $capacityFlag) {
            if (null !== $this->$capacityFlag) {
                $result[$capacityFlag] = (boolean) $this->$capacityFlag;
            }
        }

        return $result;
    }
}
