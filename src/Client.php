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
 * Class Client
 * @package Zoom
 */
class Client
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
     * Client constructor.
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

        $tag = self::tag($apiKey . $apiSecret);
        self::$clients[$tag] = $this;

        return $this;
    }

    /**
     * @param string $name
     * @return ZoomObject|null
     * @throws InvalidZoomObjectException
     */
    public function __get(string $name): ?ZoomObject
    {
        $zoomObject = null;
        $name = strtolower($name);
        if (in_array($name, array_keys(self::$zoomObjects))) {
            $klazz = self::$zoomObjects[$name];
            $zoomObject = new $klazz($this->httpClient);
        } else {
            throw new InvalidZoomObjectException("ZoomObject \"${name}\" does not exist.");
        }
        return $zoomObject;
    }

    /**
     * @param $str
     * @return string
     */
    public static function tag($str): string
    {
        return sha1($str);
    }

    /**
     * @param string $apiKey
     * @param string $apiSecret
     * @param array $config
     * @return Client
     */
    private static function getClient(string $apiKey, string $apiSecret, $config = []): Client
    {
        $tag = self::tag($apiKey . $apiSecret);
        if (array_key_exists($tag, self::$clients)) {
            return self::$clients[$tag];
        }

        $klazz = __CLASS__;
        $klazz = new $klazz($apiKey, $apiSecret, $config);
        self::$clients[$tag] = $klazz;

        return $klazz;
    }

    /**
     * @param $name
     * @param $arguments
     * @return ZoomObject
     * @throws InvalidZoomObjectException
     */
    public static function __callStatic($name, $arguments): ZoomObject
    {
        $name = strtolower(preg_replace('/^get/', '', $name));
        if (in_array($name, array_keys(self::$zoomObjects))) {
            list($apiKey, $apiSecret) = $arguments;
            $config = count($arguments) >= 3 ? $arguments[2] : null;
            return self::getClient($apiKey, $apiSecret, $config)->$name;
        } else {
            throw new InvalidZoomObjectException("ZoomObject \"${name}\" does not exist.");
        }
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
            return $request->withHeader('Authorization', 'Bearer ' . (string)$this->generateToken());
        }));
        $this->httpClient = new HttpClient(array_merge(
            ['base_uri' => self::BASE_URI, 'handler' => $stack],
            $this->config
        ));
    }
}
