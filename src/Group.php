<?php

namespace Zoom;

/**
 * Class Group
 * @package Zoom
 */
class Group extends ZoomObject
{
    /**
     * @var string
     */
    protected $baseEndpointUri = 'groups';

    /**
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function listGroups()
    {
        return $this->getObjects();
    }

    /**
     * @param string $groupId
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function retrieveGroup(string $groupId)
    {
        return $this->getObjectById($groupId);
    }
}
