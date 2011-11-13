<?php
/*
 * This file is part of PHP Selenium Library.
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Selenium\Tests\Message;

use Selenium\Capabilities;
use Selenium\Message\SessionCreateResponse;

/**
 * Tests the response object for session creation.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class SessionCreateResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the basic case
     */
    public function testSimple()
    {
        $response = new SessionCreateResponse();
        $response->addHeader('1.0 302 Moved Temporarly');
        $response->addHeader('Location: http://localhost/session/12345');

        $this->assertEquals(12345, $response->getSessionId());
    }

    /**
     * Verify handling of 500 errors
     */
    public function testInternalError()
    {
        try {
            $response = new SessionCreateResponse();
            $response->addHeader('1.0 500 Internal Error');

            $response->getSessionId();
        } catch (\RuntimeException $e) {
            $this->assertEquals('The response should be a redirection, response code from server was "500"', $e->getMessage());
        }
    }

    /**
     * Verify that incorrect redirections are correctly handled
     */
    public function testWrongRedirection()
    {
        try {
            $response = new SessionCreateResponse();
            $response->addHeader('1.0 302 Moved Temporarly');
            $response->addHeader('Location: /foo/bar');

            $response->getSessionId();
        } catch (\RuntimeException $e) {
            $this->assertEquals('The Location should end with /session/<session-id> (location returned: /foo/bar)', $e->getMessage());
        }
    }
}
