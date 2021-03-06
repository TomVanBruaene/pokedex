<?php

namespace Tests\ResponderTests;

use App\Irc\Responders\NewsResponder;
use Jerodev\PhpIrcClient\IrcChannel;
use Tests\TestCase;

class NewsResponderTest extends TestCase
{
    public function testEmptyPayload()
    {
        $responder = new NewsResponder();
        $response = $responder->handlePrivmsg('foo', new IrcChannel('#bar'), '!news  ');

        $this->assertNull($response);
    }

    public function testOutputFormat()
    {
        $responder = new NewsResponder();
        $response = $responder->handlePrivmsg('foo', new IrcChannel('#bar'), '!news Europe');

        $this->assertNotNull($response);
        $this->assertContains("\n", $response->getMessage());
    }

    public function testNoNewsFound()
    {
        $responder = new NewsResponder();
        $response = $responder->handlePrivmsg('foo', new IrcChannel('#bar'), '!news mqlkjsfmjqlkdlkhqhlkgql');

        $this->assertNotNull($response);
        $this->assertEquals('No news found for category `mqlkjsfmjqlkdlkhqhlkgql`.', $response->getMessage());
    }
}
