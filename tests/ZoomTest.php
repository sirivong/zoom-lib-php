<?php
declare(strict_types=1);

namespace ZoomTest;

use Zoom\{
    Account,
    Billing,
    Dashboard,
    Group,
    Meeting,
    Recording,
    Report,
    Role,
    User,
    Webinar,
    Zoom
};

/**
 * Class ZoomTest
 */
final class ZoomTest extends BaseTest
{
    /**
     *
     */
    public function testCanCreateAccount(): void
    {
        $this->assertInstanceOf(
            Account::class,
            $this->zoom->account
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
    public function testCanCreateBilling(): void
    {
        $this->assertInstanceOf(
            Billing::class,
            $this->zoom->billing
        );
    }

    /**
     *
     */
    public function testCanCreateDashboard(): void
    {
        $this->assertInstanceOf(
            Dashboard::class,
            $this->zoom->dashboard
        );
    }

    /**
     *
     */
    public function testCanCreateGroup(): void
    {
        $this->assertInstanceOf(
            Group::class,
            $this->zoom->group
        );
    }

    /**
     *
     */
    public function testCanCreateMeeting(): void
    {
        $this->assertInstanceOf(
            Meeting::class,
            $this->zoom->meeting
        );
    }

    /**
     *
     */
    public function testCanCreateRecording(): void
    {
        $this->assertInstanceOf(
            Recording::class,
            $this->zoom->recording
        );
    }

    /**
     *
     */
    public function testCanCreateReport(): void
    {
        $this->assertInstanceOf(
            Report::class,
            $this->zoom->report
        );
    }

    /**
     *
     */
    public function testCanCreateRole(): void
    {
        $this->assertInstanceOf(
            Role::class,
            $this->zoom->role
        );
    }

    /**
     *
     */
    public function testCanCreateUser(): void
    {
        $this->assertInstanceOf(
            User::class,
            $this->zoom->user
        );
    }

    /**
     *
     */
    public function testCanCreateWebinar(): void
    {
        $this->assertInstanceOf(
            Webinar::class,
            $this->zoom->webinar
        );
    }

    /**
     *
     */
    public function testCanCreateZoom(): void
    {
        $this->assertInstanceOf(
            Zoom::class,
            $this->zoom
        );
    }
}
