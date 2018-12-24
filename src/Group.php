<?php

namespace Zoom;

/**
 * Class Group
 * @package Zoom
 */
class Group extends Resource
{
    /**
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function groups()
    {
        return $this->getObjects();
    }

    /**
     * @param string $groupId
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function group(string $groupId)
    {
        return $this->getObject($groupId);
    }
}
