<?php

namespace Zoom;

use GuzzleHttp\Client as HttpClient;
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
    protected $baseEndpoint;

    /**
     * @var Zoom|null
     */
    protected $client = null;

    /**
     * @var bool
     */
    protected $responseAsJson = true;

    /**
     * ZoomObject constructor.
     * @param Zoom|null $client
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string|null $baseEndpoint
     * @return string
     */
    protected function baseEndpoint(string $baseEndpoint = null): string
    {
        if (empty($baseEndpoint)) {
            if (!empty($this->baseEndpoint)) {
                $baseEndpoint = $this->baseEndpoint;
            } else {
                try {
                    $baseEndpoint = strtolower((new \ReflectionClass($this))->getShortName()) . 's';
                } catch (\ReflectionException $re) {
                }
            }
        }
        return sprintf("/%s/%s", self::VERSION, $baseEndpoint);
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
     * @param array $query
     * @param string|null $endpoint
     * @return object|ResponseInterface|null
     */
    protected function getObjects(string $endpoint = null, array $query = [])
    {
        $compoundedQuery = [
            'query' => $this->buildQuery($query),
        ];
        $endpoint = $endpoint ?: $this->baseEndpoint();
        $response = $this->httpClient->get($endpoint, $compoundedQuery);
        return $this->transformResponse($response);
    }

    /**
     * @param string $objectId
     * @param array $query
     * @return object|ResponseInterface|null
     */
    protected function getObject(string $objectId, $query = [])
    {
        $compoundedQuery = [];
        if (!empty($query)) {
            $compoundedQuery = ['query' => $query];
        }
        $endpoint = sprintf("%s/%s", $this->baseEndpoint(), $objectId);
        $response = $this->httpClient->get($endpoint, $compoundedQuery);
        return $this->transformResponse($response);
    }

    /**
     * @param array $query
     * @param int $pageNumber
     * @param int $pageSize
     * @return array
     */
    protected function buildQuery($query = [], int $pageNumber = 1, int $pageSize = 30): array
    {
        $compoundedQuery = [
            'page_number' => $pageNumber,
            'page_size' => $pageSize,
        ];
        if (!empty($query)) {
            $compoundedQuery = array_merge($compoundedQuery, $query);
        }
        return $compoundedQuery;
    }
}
