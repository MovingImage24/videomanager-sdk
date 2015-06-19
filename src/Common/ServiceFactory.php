<?php

namespace Mi\VideoManager\SDK\Common;

use Mi\Guzzle\ServiceBuilder\ServiceFactoryInterface as GuzzleServiceFactoryInterface;
use Mi\Guzzle\ServiceBuilder\ServiceFactoryInterface;
use Mi\VideoManager\SDK\Common\Subscriber\ProcessErrorResponse;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ServiceFactory implements ServiceFactoryInterface
{
    private $baseServiceFactory;

    /**
     * @param GuzzleServiceFactoryInterface $baseServiceFactory
     */
    public function __construct(GuzzleServiceFactoryInterface $baseServiceFactory)
    {
        $this->baseServiceFactory = $baseServiceFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function factory($config)
    {
        $service = $this->baseServiceFactory->factory($config);
        $service->getEmitter()->attach(new ProcessErrorResponse());
        return $service;
    }
}
