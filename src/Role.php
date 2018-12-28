<?php

namespace Zoom;

/**
 * Class Role
 * @package Zoom
 */
class Role extends Resource
{
    /**
     * @var string resource base endpoint.
     */
    protected $endpoint = 'roles';

    /**
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function roles()
    {
        return $this->getObjects();
    }

    /**
     * @param int $roleId
     * @param int $pageNumber
     * @param int $pageSize
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function members(int $roleId, int $pageNumber = 1, int $pageSize = 30)
    {
        $endpoint = sprintf("%s/%s/members", $this->endpoint(), $roleId);
        $query = $this->buildQuery(['page_number' => $pageNumber, 'page_size' => $pageSize]);
        return $this->getObjects($endpoint, $query);
    }
}
