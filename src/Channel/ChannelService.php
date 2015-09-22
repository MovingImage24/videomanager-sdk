<?php

namespace Mi\VideoManager\SDK\Channel;

use GuzzleHttp\Command\Event\ProcessEvent;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

/**
 * @author Frank Mohr <frank.mohr@movingimage.com>
 * @author Volker Bredow <volker.bredow@movingimage.com>
 * @author Daniel Weise <daniel.weise@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class ChannelService extends GuzzleClient
{
    /**
     * @param int|null $page
     * @param int|null $limit
     *
     * @return \Mi\VideoManager\SDK\Model\Channel[]
     */
    public function getChannelList()
    {
        return $this->execute($this->getCommand('getChannelList', []))['rubriclist'];
    }
}
