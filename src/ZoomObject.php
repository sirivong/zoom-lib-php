<?php

namespace Zoom;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ZoomObject
 * @package Zoom
 */
abstract class ZoomObject
{
    /**
     *
     */
    const VERSION = 'v2';

    /**
     * @var string
     */
    protected $baseEndpointUri = '';

    /**
     * @var Client|null
     */
    protected $client = null;

    /**
     * @var bool
     */
    protected $responseAsJson = true;

    /**
     * ZoomObject constructor.
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client;
    }

    /**
     * @param string|null $baseEndpointUri
     * @return string
     */
    protected function baseEndpoint(string $baseEndpointUri = null): string
    {
        $baseEndpointUri = $baseEndpointUri ?: $this->baseEndpointUri;
        return sprintf("/%s/%s", self::VERSION, $baseEndpointUri);
    }

    /**
     * @param bool $condition
     * @return $this
     */
    protected function setResponseAsJson(bool $condition)
    {
        $this->responseAsJson = $condition;
        return $this;
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface|object|null
     */
    protected function transformResponse(ResponseInterface $response)
    {
        if ($this->responseAsJson) {
            return json_decode((string)$response->getBody());
        }
        return $response;
    }
}
