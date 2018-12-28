<?php

namespace Zoom;

/**
 * Class Account
 * @package Zoom
 */
class Account extends Resource
{
    /**
     * @var string resource base endpoint.
     */
    protected $endpoint = 'accounts';

    /**
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function details()
    {
        $response = $this->httpClient->get($this->endpoint());
        return $this->transform($response);
    }
}
