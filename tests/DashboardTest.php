<?php
declare(strict_types=1);

namespace ZoomTest;

use Carbon\Carbon;

/**
 * Class DashboardTest
 */
final class DashboardTest extends BaseTest
{
    /**
     *
     */
    public function testCanGetMeetings()
    {
        $to = Carbon::now();
        $from = $to->clone();
        $from->subMonth(1);
        $response = $this->client->dashboard->meetings($from, $to);
        $this->assertNotEmpty($response);
    }

    /**
     *
     */
    public function testCanGetWebinars()
    {
        $to = Carbon::now();
        $from = $to->clone();
        $from->subMonth(1);
        $response = $this->client->dashboard->webinars($from, $to);
        $this->assertNotEmpty($response);
    }
}
