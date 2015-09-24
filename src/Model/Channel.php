<?php

namespace Mi\VideoManager\SDK\Model;

/**
 * @author Frank Mohr <frank.mohr@movingimage.com>
 * @author Volker Bredow <volker.bredow@movingimage.com>
 * @author Daniel Weise <daniel.weise@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class Channel
{
    private $id;
    private $name;
    private $parentId;

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
     * the parent channel id.
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }
}
