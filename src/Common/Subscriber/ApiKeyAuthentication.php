<?php

namespace Mi\VideoManager\SDK\Common\Subscriber;

use GuzzleHttp\Command\Event\PreparedEvent;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Event\SubscriberInterface;
use Mi\VideoManager\SDK\Common\Token\ApiKeyTokenInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ApiKeyAuthentication implements SubscriberInterface
{
    private $description;
    private $apiKeyToken;

    /**
     * @param Description          $description
     * @param ApiKeyTokenInterface $apiKeyToken
     */
    public function __construct(Description $description, ApiKeyTokenInterface $apiKeyToken = null)
    {
        $this->description = $description;
        $this->apiKeyToken = $apiKeyToken;
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
        if ($this->apiKeyToken === null) {
            return;
        }

        $command = $event->getCommand();
        $operation = $this->description->getOperation($command->getName());

        if ($operation->getData('api-key-authentication') === true) {
            $query = $event->getRequest()->getQuery();

            $query->add('api_key', $this->apiKeyToken->getApiKey());
            $query->add('developer_key', $this->apiKeyToken->getDeveloperKey());
            $query->add('client_key', $this->apiKeyToken->getClientKey());
        }
    }
}
