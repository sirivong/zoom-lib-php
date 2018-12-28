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
    protected $endpoint;

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
     * @param $name
     * @param $arguments
     * @return object|ResponseInterface|null
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $name = strtolower($name);
        if (in_array($name, ['get', 'post', 'put', 'patch', 'delete'])) {
            $endpoint = null;
            $query = [];
            if (count($arguments) > 0) {
                $endpoint = $arguments[0];
                if (count($arguments) > 1) {
                    $query = $arguments[1];
                }
            } else {
                throw new \Exception("Invalid endpoint for method: ${name}");
            }
            return $this->send($name, $endpoint, $query);
        }
        throw new \Exception("Invalid method: ${name}");
    }

    /**
     * @param string|null $endpoint
     * @return string
     */
    protected function endpoint(string $endpoint = null): string
    {
        if (empty($endpoint)) {
            if (!empty($this->endpoint)) {
                $endpoint = $this->endpoint;
            } else {
                try {
                    $endpoint = strtolower((new \ReflectionClass($this))->getShortName()) . 's';
                } catch (\ReflectionException $re) {
                }
            }
        }
        return sprintf("/%s/%s", self::VERSION, $endpoint);
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
        $endpoint = $endpoint ?: $this->endpoint();
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
        $endpoint = sprintf("%s/%s", $this->endpoint(), $objectId);
        return $this->get($endpoint, $query);
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
        if (!in_array($method, ['get', 'post', 'put', 'patch', 'delete'])) {
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
     * @return array
     */
    protected function buildQuery($query = []): array
    {
        $compoundedQuery = [
            'page_number' => 1,
            'page_size' => 30,
        ];
        if (!empty($query)) {
            $compoundedQuery = array_merge($compoundedQuery, $query);
        }
        foreach ($compoundedQuery as $k => $v) {
            if ($v === null) {
                unset($compoundedQuery[$k]);
            }
        }
        return $compoundedQuery;
    }
}
