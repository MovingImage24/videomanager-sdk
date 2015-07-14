<?php

namespace Mi\VideoManager\SDK\Common\Token;

/**
 * @author Steve Reichenbach <steve.reichenbach@movingimage.com>
 */
class UserToken implements UserTokenInterface
{
    private $userToken;

    /**
     * @param string $userToken
     */
    public function __construct($userToken)
    {
        $this->userToken = $userToken;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->userToken;
    }
}
