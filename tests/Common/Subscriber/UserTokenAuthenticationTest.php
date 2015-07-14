<?php

namespace Mi\VideoManager\SDK\Tests\Common\Subscriber;

use GuzzleHttp\Command\Command;
use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Query;
use Mi\VideoManager\SDK\Common\Subscriber\UserTokenAuthentication;
use Mi\VideoManager\SDK\Common\Token\ApiKeyTokenInterface;
use Mi\VideoManager\SDK\Common\Token\UserTokenInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 * 
 * @covers Mi\VideoManager\SDK\Common\Subscriber\UserTokenAuthentication
 */
class UserTokenAuthenticationTest extends \PHPUnit_Framework_TestCase
{
    private $command;
    private $description;
    private $operation;
    private $userToken;

    /**
     * @var UserTokenAuthentication
     */
    private $authentication;


    /**
     * @test
     */
    public function processWithoutUserTokenAuthentication()
    {
        $event = $this->prophesize(PreparedEvent::class);

        $this->command->getName()->willReturn('command');
        $this->description->getOperation('command')->willReturn($this->operation->reveal());

        $this->operation->getData('user-token-authentication')->willReturn(null);

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

        $this->operation->getData('user-token-authentication')->willReturn(true);

        $request->getQuery()->willReturn($query->reveal());

        $event->getRequest()->willReturn($request->reveal());
        $event->getCommand()->willReturn($this->command->reveal());

        $this->userToken->getToken()->willReturn('token');

        $query->add('user_api_token', 'token')->shouldBeCalled();

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
        $this->userToken = $this->prophesize(UserTokenInterface::class);

        $this->authentication = new UserTokenAuthentication($this->description->reveal(),$this->userToken->reveal());
    }
}
