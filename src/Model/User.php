<?php

namespace Mi\VideoManager\SDK\Model;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class User
{
    private $username;
    private $email;
    private $id;
    private $videoManagerId;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
