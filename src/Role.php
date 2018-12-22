<?php

namespace Zoom;

/**
 * Class Role
 * @package Zoom
 */
class Role extends ZoomObject
{
    /**
     * @var string
     */
    protected $baseEndpointUri = 'roles';

    /**
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function listRoles()
    {
        $response = $this->client->get($this->baseEndpoint());
        return $this->transformResponse($response);
    }

    /**
     * @param int $roleId
     * @param int $pageNumber
     * @param int $pageSize
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function listMembers(int $roleId, int $pageNumber = 1, int $pageSize = 30)
    {
        $endpoint = sprintf("%s/%s/members", $this->baseEndpoint(), $roleId);
        $options = [
            'page_number' => $pageNumber,
            'page_size' => $pageSize,
        ];
        $response = $this->client->get($endpoint, $options);
        return $this->transformResponse($response);
    }
}
