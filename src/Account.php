<?php

namespace Zoom;

/**
 * Class Account
 * @package Zoom
 */
class Account extends ZoomObject
{
    /**
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function details()
    {
        $response = $this->httpClient->get($this->baseEndpoint());
        return $this->transformResponse($response);
    }
}
