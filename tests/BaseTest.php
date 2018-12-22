<?php
declare(strict_types=1);

namespace ZoomTest;

use Zoom\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseTest
 */
abstract class BaseTest extends TestCase
{
    /**
     * @var null
     */
    protected $client = null;

    /**
     * @throws \Exception
     */
    public function setUp()
    {
        parent::setUp();
        $apiKey = getenv('ZOOM_API_KEY') ?: '';
        $apiSecret = getenv('ZOOM_API_SECRET') ?: '';

        if (empty($apiKey) || empty($apiSecret)) {
            throw new \Exception('ZOOM_API_KEY or ZOOM_API_SECRET environment variables is net set.');
        }

        $options = [];
        $this->client = new Client($apiKey, $apiSecret, $options);
    }
}
