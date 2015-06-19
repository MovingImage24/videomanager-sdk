<?php

namespace Mi\VideoManager\SDK\Tests\Common\Subscriber;

use GuzzleHttp\Command\Event\ProcessEvent;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;
use Mi\VideoManager\SDK\Common\Subscriber\ProcessErrorResponse;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 * 
 * @covers Mi\VideoManager\SDK\Common\Subscriber\ProcessErrorResponse
 */
class ProcessErrorResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function processWithoutError()
    {
        $errorResponse = new ProcessErrorResponse();
        $event = $this->prophesize(ProcessEvent::class);
        $response = $this->prophesize(Response::class);

        $event->getResponse()->willReturn($response->reveal());

        $response->json()->willReturn([]);

        $errorResponse->onProcess($event->reveal());

    }

    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     * @expectedExceptionMessage msg
     * @test
     */
    public function process()
    {
        $errorResponse = new ProcessErrorResponse();
        $event = $this->prophesize(ProcessEvent::class);
        $request = $this->prophesize(Request::class);
        $response = $this->prophesize(Response::class);

        $event->getResponse()->willReturn($response->reveal());
        $event->getRequest()->willReturn($request->reveal());

        $response->json()->willReturn(['error' => 'msg', 'errorcode' => 'code']);

        $errorResponse->onProcess($event->reveal());

    }

    /**
     * @test
     */
    public function getEvents()
    {
        self::assertInternalType('array', (new ProcessErrorResponse())->getEvents());
    }
}
