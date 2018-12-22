<?php
declare(strict_types=1);

namespace ZoomTest;

use GuzzleHttp\Exception\ClientException;

/**
 * Class AccountTest
 */
final class AccountTest extends BaseTest
{
    public function testCanGetDetails(): void
    {
        try {
            $response = $this->client->account->details();
            $this->assertNotNull($response);
        } catch (ClientException $ce) {
        }
    }
}
