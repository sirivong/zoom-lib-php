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
    protected $apiObjects = [
        'account',
        'meeting',
        'role',
        'user',
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
    protected $client;

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

        return $this;
    }

    /**
     * @param string $name
     * @return ZoomObject|null
     */
    public function __get(string $name): ?ZoomObject
    {
        $apiObject = null;
        if (in_array(strtolower($name), $this->apiObjects)) {
            $klazz = __NAMESPACE__ . '\\' . ucfirst($name);
            if (class_exists($klazz)) {
                $apiObject = new $klazz($this->client);
            }
        }
        return $apiObject;
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
        $this->client = new HttpClient(array_merge(
            ['base_uri' => self::BASE_URI, 'handler' => $stack],
            $this->config
        ));
    }
}