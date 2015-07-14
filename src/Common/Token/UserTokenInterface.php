<?php

namespace Mi\VideoManager\SDK\Common\Token;

/**
 * @author Steve Reichenbach <steve.reichenbach@movingimage.com>
 */
interface UserTokenInterface
{
    /**
     * @return string
     */
    public function getToken();
}
