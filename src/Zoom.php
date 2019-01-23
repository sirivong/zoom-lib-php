<?php
declare(strict_types=1);

namespace Zoom;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\Builder;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use Zoom\Transformers\Transformer;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Client as HttpClient;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zoom\Exceptions\InvalidResourceException;
use Zoom\Exceptions\InvalidHttpMethodException;

/**
 * Class Zoom
 * @package Zoom
 */
class Zoom
{
    /**
     * Base URI
     */
    const BASE_URI = 'https://api.zoom.us';

    const DEFAULT_PAGE_NUMBER = 1;
    const DEFAULT_PAGE_SIZE = 30;

    /**
     * Standard HTTP verbs.
     */
    const HTTP_METHODS = ['get', 'post', 'put', 'patch', 'delete'];

    /**
     * @var array
     */
    private static $resources = [
        'account' => Account::class,
        'billing' => Billing::class,
        'dashboard' => Dashboard::class,
        'group' => Group::class,
        'meeting' => Meeting::class,
        'recording' => Recording::class,
        'role' => Role::class,
        'report' => Report::class,
        'user' => User::class,
        'webinar' => Webinar::class,
    ];

    /**
     * @var mixed
     */
    protected $apiKey;

    /**
     * @var mixed
     */
    protected $apiSecret;

    /**
     * @var
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $config;

    /**
     * Zoom constructor.
     * @param string $apiKey
     * @param string $apiSecret
     * @param array $config
     */
    public function __construct(string $apiKey, string $apiSecret, array $config = [])
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->config = $config;
        $this->initHttpClient();
        return $this;
    }

    /**
     * @param string $name
     * @return Resource|null
     * @throws InvalidResourceException
     */
    public function __get(string $name): ?Resource
    {
        $name = strtolower($name);
        if (in_array($name, array_keys(self::$resources))) {
            $class = self::$resources[$name];
            return new $class($this);
        }
        throw new InvalidResourceException("Resource \"${name}\" does not exist.");
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
            $transformer = null;
            if (count($arguments) > 0) {
                $endpoint = $arguments[0];
                if (count($arguments) > 1) {
                    $query = $arguments[1];
                }
                if (count($arguments) > 2) {
                    $transformer = $arguments[2];
                }
            } else {
                throw new InvalidResourceException("Invalid endpoint for method: ${name}");
            }
            return $this->request($name, $endpoint, $query, $transformer);
        }
        throw new InvalidHttpMethodException("Invalid method: ${name}");
    }

    /**
     * @param $name
     * @param $arguments
     * @return Resource
     * @throws InvalidResourceException
     */
    public static function __callStatic($name, $arguments): Resource
    {
        $_name = strtolower($name);
        if (in_array($_name, array_keys(self::$resources))) {
            list($apiKey, $apiSecret) = $arguments;
            $config = count($arguments) >= 3 ? $arguments[2] : [];
            $class = __CLASS__;
            return (new $class($apiKey, $apiSecret, $config))->$_name;
        }
        throw new InvalidResourceException("Resource \"${name}\" does not exist.");
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $query
     * @param Transformer $transformer
     * @return object|ResponseInterface|null
     * @throws \Exception
     */
    protected function request(string $method, string $endpoint, $query = [], Transformer $transformer = null)
    {
        $method = strtolower($method);
        if (!in_array($method, self::HTTP_METHODS)) {
            throw new InvalidHttpMethodException("Invalid method: ${method}");
        }
        $content = $this->buildQuery($query);
        $response = $this->httpClient->$method($endpoint, $content);
        if ($transformer) {
            return $transformer->transform($response);
        }
        return $response;
    }

    /**
     * @param int $ttl
     * @return \Lcobucci\JWT\Token
     */
    protected function generateToken(int $ttl = 60): Token
    {
        $signer = new Sha256();
        $token = (new Builder())
            ->setIssuer($this->apiKey)
            ->setExpiration(time() + $ttl)
            ->sign($signer, $this->apiSecret)
            ->getToken();

        return $token;
    }

    /**
     * @param array $query
     * @return array
     */
    protected function buildQuery($query = []): array
    {
        $compoundedQuery = [
            'query' => [
                'page_number' => self::DEFAULT_PAGE_NUMBER,
                'page_size' => self::DEFAULT_PAGE_SIZE,
            ]
        ];

        if (!empty($query)) {
            if (array_key_exists('query', $query)) {
                $compoundedQuery = array_merge_recursive($compoundedQuery, $query);
            } else {
                $compoundedQuery = array_merge($compoundedQuery, ['query' => $query]);
            }
            $compoundedQuery['query'] = array_filter($compoundedQuery['query'], function ($v) {
                return $v !== null;
            });

            unset($query['query']);
            if (!empty($query)) {
                $compoundedQuery = array_merge_recursive($compoundedQuery, $query);
            }
        }
        return $compoundedQuery;
    }

    /**
     *
     */
    protected function initHttpClient(): void
    {
        $stack = HandlerStack::create(new CurlHandler());
        $stack->push(Middleware::mapRequest(function (RequestInterface $request) {
            return $request->withHeader('Authorization', 'Bearer ' . (string)$this->generateToken())
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('Accept', 'application/json');
        }));
        $this->httpClient = new HttpClient(array_merge(
            ['base_uri' => self::BASE_URI, 'handler' => $stack],
            $this->config
        ));
    }
}
