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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getVideoManagerId()
    {
        return $this->videoManagerId;
    }
}
