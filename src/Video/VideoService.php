<?php

namespace Mi\VideoManager\SDK\Video;

use GuzzleHttp\Command\Event\ProcessEvent;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class VideoService extends GuzzleClient
{
    /**
     * @param int|null $page
     * @param int|null $limit
     *
     * @return \Mi\VideoManager\SDK\Model\Video[]
     */
    public function getVideoList($page = null, $limit = null)
    {
        return $this->execute($this->getCommand('getVideoList', ['page' => $page, 'limit' => $limit]))['videolist'];
    }

    /**
     * @param int $videoId
     *
     * @return \Mi\VideoManager\SDK\Model\VideoObject
     */
    public function getVideo($videoId)
    {
        return $this->execute($this->getCommand('getVideo', ['videoId' => $videoId]));
    }

    /**
     * @return int
     */
    public function getVideoListCount()
    {
        return $this->execute($this->getCommand('getVideoListCount'))['videocount'];
    }

    /**
     * @param int $chunkSize
     *
     * @return \Mi\VideoManager\SDK\Model\Video[]
     */
    public function getAllVideos($chunkSize = 1000)
    {
        $result     = [];
        $videoCount = $this->getVideoListCount();
        $maxPage    = ceil($videoCount / $chunkSize);
        $commands   = [];
        $videoList  = [];

        for ($page = 1; $page <= $maxPage; $page++) {
            $commands[] = $this->getCommand('getVideoList', ['page' => $page, 'limit' => $chunkSize]);
        }

        $options['process'] = function (ProcessEvent $e) use (&$result) {
            $result[(int)$e->getRequest()->getQuery()->get('page')] = $e->getResult()['videolist'];
        };

        $this->createPool($commands, $options)->wait();
        ksort($result);

        array_walk(
            $result,
            function ($v) use (&$videoList) {
                $videoList = array_merge($videoList, $v);
            }
        );

        return $videoList;
    }
}
