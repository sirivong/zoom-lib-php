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
    protected $baseEndpointUri;

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
        if (empty($baseEndpointUri)) {
            if (!empty($this->baseEndpointUri)) {
                $baseEndpointUri = $this->baseEndpointUri;
            } else {
                try {
                    $baseEndpointUri = strtolower((new \ReflectionClass($this))->getShortName()) . 's';
                } catch (\ReflectionException $re) {
                }
            }
        }
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

    /**
     * @param int $pageNumber
     * @param int $pageSize
     * @param array $query
     * @param null $endpoint
     * @return object|ResponseInterface|null
     */
    public function getObjects(int $pageNumber = 1, int $pageSize = 30, $query = [], $endpoint = null)
    {
        $options = [
            'query' => [
                'page_number' => $pageNumber,
                'page_size' => $pageSize,
            ]
        ];
        if (!empty($query)) {
            $options = array_merge_recursive($options, [
                'query' => $query
            ]);
        }
        $endpoint = $endpoint ?: $this->baseEndpoint();
        $response = $this->client->get($endpoint, $options);
        return $this->transformResponse($response);
    }

    /**
     * @param string $objectId
     * @param array $query
     * @return object|ResponseInterface|null
     */
    public function getObjectById(string $objectId, $query = [])
    {
        $options = [];
        if (!empty($query)) {
            $options = [
                'query' => $query
            ];
        }
        $endpoint = sprintf("%s/%s", $this->baseEndpoint(), $objectId);
        $response = $this->client->get($endpoint, $options);
        return $this->transformResponse($response);
    }
}
