<?php

namespace Mi\VideoManager\SDK\Common;

use Mi\Guzzle\ServiceBuilder\ServiceFactoryInterface as GuzzleServiceFactoryInterface;
use Mi\Guzzle\ServiceBuilder\ServiceFactoryInterface;
use Mi\VideoManager\SDK\Common\Subscriber\ApiKeyAuthentication;
use Mi\VideoManager\SDK\Common\Subscriber\ProcessErrorResponse;
use Mi\VideoManager\SDK\Common\Token\ApiKeyTokenInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ServiceFactory implements ServiceFactoryInterface
{
    private $baseServiceFactory;
    private $apiKeyToken;

    /**
     * @param GuzzleServiceFactoryInterface $baseServiceFactory
     * @param ApiKeyTokenInterface          $apiKeyToken
     */
    public function __construct(GuzzleServiceFactoryInterface $baseServiceFactory, ApiKeyTokenInterface $apiKeyToken)
    {
        $this->baseServiceFactory = $baseServiceFactory;
        $this->apiKeyToken        = $apiKeyToken;
    }

    /**
     * {@inheritdoc}
     */
    public function factory($config)
    {
        $service = $this->baseServiceFactory->factory($config);
        $service->getEmitter()->attach(new ProcessErrorResponse());
        $service->getEmitter()->attach(new ApiKeyAuthentication($service->getDescription(), $this->apiKeyToken));

        return $service;
    }
}
