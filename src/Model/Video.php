<?php

namespace Mi\VideoManager\SDK\Model;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class Video
{
    private $id;
    private $name;
    private $thumbnail;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * thumbnail path without host and scheme.
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
}
