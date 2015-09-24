<?php

namespace Mi\VideoManager\SDK\Security;

use GuzzleHttp\Command\Guzzle\GuzzleClient;
use Mi\VideoManager\SDK\Model\User;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class SecurityService extends GuzzleClient
{
    /**
     * @param string $username
     * @param array  $password
     *
     * @return string
     */
    public function login($username, $password)
    {
        return $this->execute($this->getCommand('login', ['username' => $username,'password' => $password]));
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function getUser($username)
    {
        return $this->execute($this->getCommand('getUser', ['username' => $username]));
    }

    /**
     * @return string[]
     */
    public function getVideoManagerList()
    {
        return $this->execute($this->getCommand('getVideoManagerList'));
    }
}
