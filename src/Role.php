<?php

namespace Zoom;

/**
 * Class Role
 * @package Zoom
 */
class Role extends ZoomObject
{
    /**
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function getRoles()
    {
        return $this->getObjects();
    }

    /**
     * @param int $roleId
     * @param int $pageNumber
     * @param int $pageSize
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function getMembers(int $roleId, int $pageNumber = 1, int $pageSize = 30)
    {
        $endpoint = sprintf("%s/%s/members", $this->baseEndpoint(), $roleId);
        return $this->getObjects($pageNumber, $pageSize, null, $endpoint);
    }
}
