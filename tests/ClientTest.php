<?php
declare(strict_types=1);

namespace ZoomTest;

use Zoom\Role;
use Zoom\User;
use Zoom\Group;
use Zoom\Zoom;
use Zoom\Account;

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
            Zoom::getAccount($this->apiKey, $this->apiSecret)
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
}
