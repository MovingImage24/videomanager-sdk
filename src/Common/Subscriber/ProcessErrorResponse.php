<?php

namespace Mi\VideoManager\SDK\Common\Subscriber;

use GuzzleHttp\Command\Event\ProcessEvent;
use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Exception\BadResponseException;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class ProcessErrorResponse implements SubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEvents()
    {
        return ['process' => ['onProcess', 120]];
    }

    /**
     * @param ProcessEvent $event
     */
    public function onProcess(ProcessEvent $event)
    {
        $jsonResponse = $event->getResponse()->json();

        if (is_array($jsonResponse) && array_key_exists('error', $jsonResponse) && array_key_exists('errorcode', $jsonResponse)) {
            throw new BadResponseException($jsonResponse['error'], $event->getRequest());
        }
    }

}
