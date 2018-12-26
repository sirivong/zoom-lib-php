<?php
declare(strict_types=1);

namespace ZoomTest;

use Zoom\{
    Account,
    Billing,
    Group,
    Report,
    Role,
    User,
    Zoom
};

/**
 * Class ClientTest
 */
final class ClientTest extends BaseTest
{
    /**
     *
     */
    public function testCanCreateClient(): void
    {
        $this->assertInstanceOf(
            Zoom::class,
            $this->client
        );
    }

    /**
     *
     */
    public function testCanCreateAccount(): void
    {
        $this->assertInstanceOf(
            Account::class,
            $this->client->account
        );
    }

    /**
     *
     */
    public function testCanCreateAccountStatically(): void
    {
        $this->assertInstanceOf(
            Account::class,
            Zoom::Account($this->apiKey, $this->apiSecret)
        );
    }


    /**
     *
     */
    public function testCanCreateUser(): void
    {
        $this->assertInstanceOf(
            User::class,
            $this->client->user
        );
    }

    public function testCanCreateRole(): void
    {
        $this->assertInstanceOf(
            Role::class,
            $this->client->role
        );
    }

    public function testCanCreateGroup(): void
    {
        $this->assertInstanceOf(
            Group::class,
            $this->client->group
        );
    }

    public function testCanCreateBilling(): void
    {
        $this->assertInstanceOf(
            Billing::class,
            $this->client->billing
        );
    }

    public function testCanCreateReport(): void
    {
        $this->assertInstanceOf(
            Report::class,
            $this->client->report
        );
    }
}
