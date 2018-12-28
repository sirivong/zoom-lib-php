<?php

namespace Zoom;

use Zoom\Transformers\Transformer;
use GuzzleHttp\Client as HttpClient;
use Zoom\Transformers\JsonTransformer;
use Psr\Http\Message\ResponseInterface;
use Zoom\Exceptions\InvalidResourceException;
use Zoom\Exceptions\InvalidHttpMethodException;

/**
 * Class Resource
 * @package Zoom
 */
abstract class Resource
{
    const PAGE_NUMBER = 1;
    const PAGE_SIZE = 30;

    /**
     * API version.
     */
    const VERSION = 'v2';

    /**
     * Standard HTTP verbs.
     */
    const HTTP_METHODS = ['get', 'post', 'put', 'patch', 'delete'];

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
     * @var JsonTransformer
     */
    protected $transformer;

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
     * @param Transformer $transformer
     * @return $this
     */
    public function transformer(Transformer $transformer)
    {
        $this->transformer = $transformer;
        return $this;
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
        if (in_array($name, self::HTTP_METHODS)) {
            $endpoint = null;
            $query = [];
            if (count($arguments) > 0) {
                $endpoint = $arguments[0];
                if (count($arguments) > 1) {
                    $query = $arguments[1];
                }
            } else {
                throw new InvalidResourceException("Invalid endpoint for method: ${name}");
            }
            return $this->send($name, $endpoint, $query);
        }
        throw new InvalidHttpMethodException("Invalid method: ${name}");
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
     * @param ResponseInterface $response
     * @return ResponseInterface|object|null
     */
    protected function transform(ResponseInterface $response)
    {
        if ($this->transformer === null) {
            $this->transformer = new JsonTransformer();
        }
        return $this->transformer->transform($response);
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
        return $this->transform($response);
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
        if (!in_array($method, self::HTTP_METHODS)) {
            throw new InvalidHttpMethodException("Invalid method: ${method}");
        }
        $compoundedQuery = [];
        if (!empty($query)) {
            $compoundedQuery = ['query' => $query];
        }
        $response = $this->httpClient->$method($endpoint, $compoundedQuery);
        return $this->transform($response);
    }

    /**
     * @param array $query
     * @return array
     */
    protected function buildQuery($query = []): array
    {
        $compoundedQuery = [
            'page_number' => self::PAGE_NUMBER,
            'page_size' => self::PAGE_SIZE,
        ];
        if (!empty($query)) {
            $compoundedQuery = array_merge($compoundedQuery, $query);
            $compoundedQuery = array_filter($compoundedQuery, function ($v) {
                return $v !== null;
            });
        }
        return $compoundedQuery;
    }
}
