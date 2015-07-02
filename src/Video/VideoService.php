<?php

namespace Mi\VideoManager\SDK\Video;

use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Mi\VideoManager\SDK\Model\Video;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class VideoService extends GuzzleClient
{
    /**
     * @return Video[]
     */
    public function getVideoList()
    {
        return $this->execute($this->getCommand('getVideoList'))['videolist'];
    }
}
