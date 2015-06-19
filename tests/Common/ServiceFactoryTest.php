<?php

namespace Mi\VideoManager\SDK\Tests\Common;

use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Event\Emitter;
use Mi\Guzzle\ServiceBuilder\ServiceFactoryInterface;
use Mi\VideoManager\SDK\Common\ServiceFactory;
use Mi\VideoManager\SDK\Common\Subscriber\ProcessErrorResponse;
use Prophecy\Argument;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 * 
 * @covers Mi\VideoManager\SDK\Common\ServiceFactory
 */
class ServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function factory()
    {
        $baseFactory = $this->prophesize(ServiceFactoryInterface::class);
        $serviceFactory = new ServiceFactory($baseFactory->reveal());
        $client = $this->prophesize(GuzzleClient::class);
        $emitter = $this->prophesize(Emitter::class);

        $client->getEmitter()->willReturn($emitter->reveal());

        $emitter->attach(Argument::type(ProcessErrorResponse::class))->shouldBeCalled();

        $baseFactory->factory(['class' => GuzzleClient::class, 'description' => []])->willReturn($client->reveal());

        $service = $serviceFactory->factory(['class' => GuzzleClient::class, 'description' => []]);

        self::assertInstanceOf(GuzzleClient::class, $service);
    }
}
