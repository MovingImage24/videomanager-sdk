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
        $apiKey = '12de-fb29-2946-bfd0-a2d0-3b69-Djp4-dc3b-809e-f981';
        $developerKey = '5915-f8cc-4777-7a5a-416b-8bQ2-12e4-dc3b-809f-091d';

        return $this->execute($this->getCommand('getVideoList', ['apiKey' => $apiKey, 'developerKey' => $developerKey]))['videolist'];
    }
}
