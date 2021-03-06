<?php
declare(strict_types=1);

namespace ZoomTest;

use GuzzleHttp\Exception\ClientException;

/**
 * Class AccountTest
 */
final class AccountTest extends BaseTest
{
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

    /**
     *
     */
    public function testCanGetInfo(): void
    {
        try {
            $response = $this->zoom->account->get();
            $this->assertNotNull($response);
        } catch (ClientException $ce) {
        }
    }
}
