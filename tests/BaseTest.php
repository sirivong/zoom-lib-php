<?php
declare(strict_types=1);

namespace ZoomTest;

use Zoom\Zoom;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseTest
 */
abstract class BaseTest extends TestCase
{
    /**
     * @var
     */
    protected $apiKey;

    /**
     * @var
     */
    protected $apiSecret;

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
        $this->apiKey = getenv('ZOOM_API_KEY') ?: '';
        $this->apiSecret = getenv('ZOOM_API_SECRET') ?: '';

        if (empty($this->apiKey) || empty($this->apiSecret)) {
            throw new \Exception('ZOOM_API_KEY or ZOOM_API_SECRET environment variables is net set.');
        }

        $options = [];
        $this->client = new Zoom($this->apiKey, $this->apiSecret, $options);
    }
}
