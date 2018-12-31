<?php
declare(strict_types=1);

namespace ZoomTest;

/**
 * Class ReportTest
 */
final class ReportTest extends BaseTest
{
    /**
     *
     */
    public function testCanGetDailyReport(): void
    {
        $response = $this->zoom->report->dailyReport();
        $this->assertGreaterThan(0, count($response->dates));
    }
}
