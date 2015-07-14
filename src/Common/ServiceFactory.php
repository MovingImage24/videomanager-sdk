<?php

namespace Mi\VideoManager\SDK\Common;

use Mi\Guzzle\ServiceBuilder\ServiceFactoryInterface as GuzzleServiceFactoryInterface;
use Mi\Guzzle\ServiceBuilder\ServiceFactoryInterface;
use Mi\VideoManager\SDK\Common\Subscriber\ApiKeyAuthentication;
use Mi\VideoManager\SDK\Common\Subscriber\ProcessErrorResponse;
use Mi\VideoManager\SDK\Common\Subscriber\UserTokenAuthentication;
use Mi\VideoManager\SDK\Common\Token\ApiKeyTokenInterface;
use Mi\VideoManager\SDK\Common\Token\UserTokenInterface;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ServiceFactory implements ServiceFactoryInterface
{
    private $baseServiceFactory;
    private $apiKeyToken;
    private $userToken;

    /**
     * @param GuzzleServiceFactoryInterface $baseServiceFactory
     * @param ApiKeyTokenInterface          $apiKeyToken
     * @param UserTokenInterface            $userToken
     */
    public function __construct(
        GuzzleServiceFactoryInterface $baseServiceFactory,
        ApiKeyTokenInterface $apiKeyToken = null,
        UserTokenInterface $userToken = null
    ) {
        $this->baseServiceFactory = $baseServiceFactory;
        $this->apiKeyToken        = $apiKeyToken;
        $this->userToken          = $userToken;
    }

    /**
     * {@inheritdoc}
     */
    public function factory($config)
    {
        $service = $this->baseServiceFactory->factory($config);
        $service->getEmitter()->attach(new ProcessErrorResponse());
        $service->getEmitter()->attach(new ApiKeyAuthentication($service->getDescription(), $this->apiKeyToken));
        $service->getEmitter()->attach(new UserTokenAuthentication($service->getDescription(), $this->userToken));

        return $service;
    }
}
