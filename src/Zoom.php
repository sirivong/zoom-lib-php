<?php
declare(strict_types=1);

namespace Zoom;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\Builder;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Client as HttpClient;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Psr\Http\Message\RequestInterface;
use Zoom\Exception\InvalidZoomObjectException;

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

    /**
     * @var array
     */
    private static $clients = [];

    /**
     * @var array
     */
    private static $zoomObjects = [
        'account' => Account::class,
        'group' => Group::class,
        'meeting' => Meeting::class,
        'recording' => Recording::class,
        'role' => Role::class,
        'user' => User::class,
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

        $this->initialize();

        $hashKey = self::hashKey($apiKey, $apiSecret);
        self::$clients[$hashKey] = $this;

        return $this;
    }

    /**
     * @param string $name
     * @return Resource|null
     * @throws InvalidZoomObjectException
     */
    public function __get(string $name): ?Resource
    {
        $name = strtolower($name);
        if (in_array($name, array_keys(self::$zoomObjects))) {
            $klazz = self::$zoomObjects[$name];
            return new $klazz($this->httpClient, $this);
        }
        throw new InvalidZoomObjectException("Resource \"${name}\" does not exist.");
    }

    /**
     * @param string $apiKey
     * @param string $apiSecret
     * @return string
     */
    public static function hashKey(string $apiKey, string $apiSecret): string
    {
        // $hashKey = sha1($str);
        $hashKey = $apiKey . $apiSecret;
        return $hashKey;
    }

    /**
     * @param string $apiKey
     * @param string $apiSecret
     * @param array $config
     * @return Zoom
     */
    private static function getClient(string $apiKey, string $apiSecret, $config = []): Zoom
    {
        $hashKey = self::hashKey($apiKey, $apiSecret);
        if (array_key_exists($hashKey, self::$clients)) {
            return self::$clients[$hashKey];
        }

        $klazz = __CLASS__;
        $klazz = new $klazz($apiKey, $apiSecret, $config);
        self::$clients[$hashKey] = $klazz;

        return $klazz;
    }

    /**
     * @param $name
     * @param $arguments
     * @return Resource
     * @throws InvalidZoomObjectException
     */
    public static function __callStatic($name, $arguments): Resource
    {
        $name = preg_replace('/^get/', '', strtolower($name));
        if (in_array($name, array_keys(self::$zoomObjects))) {
            list($apiKey, $apiSecret) = $arguments;
            $config = count($arguments) >= 3 ? $arguments[2] : null;
            return self::getClient($apiKey, $apiSecret, $config)->$name;
        }
        throw new InvalidZoomObjectException("Resource \"${name}\" does not exist.");
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
     *
     */
    protected function initialize(): void
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
