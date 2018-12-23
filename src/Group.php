<?php

namespace Zoom;

/**
 * Class Group
 * @package Zoom
 */
class Group extends ZoomObject
{
    /**
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function getGroups()
    {
        return $this->getObjects();
    }

    /**
     * @param string $groupId
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function getGroup(string $groupId)
    {
        return $this->getObjectById($groupId);
    }
}
