<?php

namespace Mi\VideoManager\SDK\Common\Token;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
interface ApiKeyTokenInterface
{
    /**
     * @return string
     */
    public function getClientKey();

    /**
     * @return string
     */
    public function getApiKey();

    /**
     * @return string
     */
    public function getDeveloperKey();
}
