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
     * @param array    $optionalParameters
     *
     * @return \Mi\VideoManager\SDK\Model\Video[]
     */
    public function getVideoList($page = null, $limit = null, array $optionalParameters = [])
    {
        return $this->execute($this->getVideoListCommand($page, $limit, $optionalParameters))['videolist'];
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
     * @param array $optionalParameters
     *
     * @return int
     */
    public function getVideoListCount(array $optionalParameters = [])
    {
        return $this->execute($this->getCommand('getVideoListCount', $optionalParameters))['videocount'];
    }

    /**
     * @param int   $chunkSize
     * @param array $optionalParameters
     *
     * @return \Mi\VideoManager\SDK\Model\Video[]
     */
    public function getAllVideos($chunkSize = 1000, array $optionalParameters = [])
    {
        $result = [];
        $videoCount = $this->getVideoListCount();
        $maxPage = ceil($videoCount / $chunkSize);
        $commands = [];
        $videoList = [];

        for ($page = 1; $page <= $maxPage; ++$page) {
            $commands[] = $this->getVideoListCommand($page, $chunkSize, $optionalParameters);
        }

        $options['process'] = function (ProcessEvent $e) use (&$result) {
            $result[(int) $e->getRequest()->getQuery()->get('page')] = $e->getResult()['videolist'];
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

    /**
     * @param int|null $page
     * @param int|null $limit
     * @param array    $optionalParameters
     *
     * @return \GuzzleHttp\Command\CommandInterface
     */
    private function getVideoListCommand($page = null, $limit = null, array $optionalParameters = [])
    {
        $parameters = array_merge($optionalParameters, ['page' => $page, 'limit' => $limit]);

        return $this->getCommand('getVideoList', $parameters);
    }
}
