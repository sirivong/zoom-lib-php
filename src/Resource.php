<?php

namespace Zoom;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Resource
 * @package Zoom
 */
abstract class Resource
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
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Zoom
     */
    protected $zoom;

    /**
     * @var bool
     */
    protected $responseAsJson = true;

    /**
     * Resource constructor.
     * @param HttpClient $httpClient
     * @param Zoom $zoom
     */
    public function __construct(HttpClient $httpClient, Zoom $zoom)
    {
        $this->httpClient = $httpClient;
        $this->zoom = $zoom;
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
     * @throws \Exception
     */
    protected function getObject(string $objectId, $query = [])
    {
        $endpoint = sprintf("%s/%s", $this->baseEndpoint(), $objectId);
        return $this->get($endpoint, $query);
    }

    /**
     * @param string $endpoint
     * @param array $query
     * @return object|ResponseInterface|null
     * @throws \Exception
     */
    protected function get(string $endpoint, $query = [])
    {
        return $this->send('GET', $endpoint, $query);
    }

    /**
     * @param string $endpoint
     * @param array $query
     * @return object|ResponseInterface|null
     * @throws \Exception
     */
    protected function post(string $endpoint, $query = [])
    {
        return $this->send('POST', $endpoint, $query);
    }

    /**
     * @param string $endpoint
     * @param array $query
     * @return object|ResponseInterface|null
     * @throws \Exception
     */
    protected function patch(string $endpoint, $query = [])
    {
        return $this->send('PATCH', $endpoint, $query);
    }

    /**
     * @param string $endpoint
     * @param array $query
     * @return object|ResponseInterface|null
     * @throws \Exception
     */
    protected function delete(string $endpoint, $query = [])
    {
        return $this->send('DELETE', $endpoint, $query);
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $query
     * @return object|ResponseInterface|null
     * @throws \Exception
     */
    protected function send(string $method, string $endpoint, $query = [])
    {
        $method = strtolower($method);
        $acceptedMethods = ['get', 'post', 'patch', 'delete'];
        if (!in_array($method, $acceptedMethods)) {
            throw new \Exception("Invalid method: ${method}");
        }
        $compoundedQuery = [];
        if (!empty($query)) {
            $compoundedQuery = ['query' => $query];
        }
        $response = $this->httpClient->$method($endpoint, $compoundedQuery);
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
