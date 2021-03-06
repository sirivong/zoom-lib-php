<?php

namespace Zoom;

use Zoom\Transformers\Transformer;
use GuzzleHttp\Client as HttpClient;
use Zoom\Transformers\JsonTransformer;

/**
 * Class Resource
 * @package Zoom
 */
abstract class Resource
{
    /**
     * API version.
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
     * @var JsonTransformer
     */
    protected $transformer;

    /**
     * @var Zoom
     */
    protected $zoom;

    /**
     * Resource constructor.
     * @param Zoom $zoom
     */
    public function __construct(Zoom $zoom)
    {
        $this->zoom = $zoom;
        $this->transformer = new JsonTransformer();
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
     * @param string|null $resourceId
     * @param string|null $endpoint
     * @param array $query
     * @return mixed
     */
    public function get(?string $resourceId = null, ?string $endpoint = null, ?array $query = [])
    {
        if (empty($endpoint)) {
            $endpoint = $this->endpoint();
            if (!empty($resourceId)) {
                $endpoint = sprintf("%s/%s", $endpoint, $resourceId);
            }
        }
        return $this->zoom->get($endpoint, $query, $this->transformer);
    }

    /**
     * @param string $resourceId
     * @return mixed
     */
    public function getOne(string $resourceId)
    {
        return $this->get($resourceId);
    }

    /**
     * @param string|null $resourceId
     * @param array|null $query
     * @return mixed
     */
    public function getMany(?string $resourceId = null, ?array $query = [])
    {
        return $this->get(null, $this->endpoint(), $query);
    }

    /**
     * @param string|null $endpoint
     * @return string
     */
    protected function endpoint(?string $endpoint = null): string
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
        $endpoint = preg_replace('#^/+#', '', $endpoint);
        return sprintf("/%s/%s", self::VERSION, $endpoint);
    }
}
