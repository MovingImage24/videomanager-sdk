<?php

namespace Mi\VideoManager\SDK\tests\Common\Subscriber;

use GuzzleHttp\Command\Command;
use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Query;
use Mi\VideoManager\SDK\Common\Subscriber\ApiKeyAuthentication;
use Mi\VideoManager\SDK\Common\Token\ApiKeyTokenInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 * 
 * @covers Mi\VideoManager\SDK\Common\Subscriber\ApiKeyAuthentication
 */
class ApiKeyAuthenticationTest extends \PHPUnit_Framework_TestCase
{
    private $command;
    private $description;
    private $operation;
    private $apiKey;

    /**
     * @var ApiKeyAuthentication
     */
    private $authentication;

    /**
     * @test
     */
    public function processWithoutApiKeyAuthentication()
    {
        $event = $this->prophesize(PreparedEvent::class);

        $this->command->getName()->willReturn('command');
        $this->description->getOperation('command')->willReturn($this->operation->reveal());

        $this->operation->getData('api-key-authentication')->willReturn(null);

        $event->getCommand()->willReturn($this->command->reveal());

        $this->authentication->onPrepared($event->reveal());
    }

    /**
     * @test
     */
    public function process()
    {
        $event = $this->prophesize(PreparedEvent::class);
        $request = $this->prophesize(Request::class);
        $query = $this->prophesize(Query::class);

        $this->command->getName()->willReturn('command');

        $this->description->getOperation('command')->willReturn($this->operation->reveal());

        $this->operation->getData('api-key-authentication')->willReturn(true);

        $request->getQuery()->willReturn($query->reveal());

        $event->getRequest()->willReturn($request->reveal());
        $event->getCommand()->willReturn($this->command->reveal());

        $this->apiKey->getApiKey()->willReturn('apiKey');
        $this->apiKey->getDeveloperKey()->willReturn('developerKey');
        $this->apiKey->getClientKey()->willReturn('clientKey');

        $query->add('api_key', 'apiKey')->shouldBeCalled();
        $query->add('developer_key', 'developerKey')->shouldBeCalled();
        $query->add('client_key', 'clientKey')->shouldBeCalled();

        $this->authentication->onPrepared($event->reveal());
    }

    /**
     * @test
     */
    public function getEvents()
    {
        self::assertInternalType('array', $this->authentication->getEvents());
    }

    protected function setUp()
    {
        $this->command = $this->prophesize(Command::class);
        $this->description = $this->prophesize(Description::class);
        $this->operation = $this->prophesize(Operation::class);
        $this->apiKey = $this->prophesize(ApiKeyTokenInterface::class);

        $this->authentication = new ApiKeyAuthentication($this->description->reveal(), $this->apiKey->reveal());
    }
}
