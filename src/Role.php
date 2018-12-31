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
     * @param int $roleId
     * @param array $query
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function members(int $roleId, ?array $query = [])
    {
        $endpoint = sprintf("%s/%s/members", $this->endpoint(), $roleId);
        return $this->get(null, $endpoint, $query);
    }
}
