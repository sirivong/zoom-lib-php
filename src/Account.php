<?php

namespace Zoom;

/**
 * Class Account
 * @package Zoom
 */
class Account extends ZoomObject
{
    /**
     * @var string
     */
    protected $baseEndpointUri = 'accounts';

    /**
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function details()
    {
        $response = $this->client->get($this->baseEndpoint());
        return $this->transformResponse($response);
    }
}
