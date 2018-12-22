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
        $response = $this->client->get($this->baseEndpoint());
        return $this->transformResponse($response);
    }

    /**
     * @param string $groupId
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function retrieveGroup(string $groupId)
    {
        $endpoint = sprintf("%s/%s", $this->baseEndpoint(), $groupId);
        $response = $this->client->get($endpoint);
        return $this->transformResponse($response);
    }
}
