<?php

namespace Mi\VideoManager\SDK\Common\Subscriber;

use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Event\SubscriberInterface;
use Mi\VideoManager\SDK\Common\Token\UserTokenInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class UserTokenAuthentication implements SubscriberInterface
{
    private $description;
    private $userToken;

    /**
     * @param Description        $description
     * @param UserTokenInterface $userToken
     */
    public function __construct(Description $description, UserTokenInterface $userToken = null)
    {
        $this->description = $description;
        $this->userToken   = $userToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvents()
    {
        return ['prepared' => ['onPrepared', 'last']];
    }

    public function onPrepared(PreparedEvent $event)
    {
        if ($this->userToken === null) {
            return;
        }

        $command   = $event->getCommand();
        $operation = $this->description->getOperation($command->getName());

        if ($operation->getData('user-token-authentication') === true) {
            $query = $event->getRequest()->getQuery();

            $query->add('user_api_token', $this->userToken->getToken());
        }
    }
}
