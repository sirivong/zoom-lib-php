<?php
declare(strict_types=1);

namespace ZoomTest;

use GuzzleHttp\Exception\ClientException;

/**
 * Class BillingTest
 */
final class BillingTest extends BaseTest
{
    protected $accountId;

    /**
     * @throws \Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->accountId = getenv('ZOOM_TEST_ACCOUNT_ID') ?: '';
        if (empty($this->accountId)) {
            throw new \Exception('ZOOM_TEST_ACCOUNT_ID environment variable is not set.');
        }
    }

    public function testCanGetInfo(): void
    {
        try {
            $response = $this->zoom->billing->get();
            $this->assertNotNull($response);
        } catch (ClientException $ce) {
        }
    }
}
