<?php

namespace Zoom;

use Carbon\Carbon;

/**
 * Class Report
 * @package Zoom
 */
class Report extends Resource
{
    /**
     * @var string
     */
    protected $baseEndpoint = 'report';

    /**
     * @param int $month
     * @param int $year
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function getDailyReport(int $month = -1, int $year = -1)
    {
        if (!($month && $year)) {
            $now = Carbon::now();
            $month = $now->month;
            $year = $now->year;
        }
        $query = [
            'query' => [
                'month' => $month,
                'year' => $year,
            ]
        ];
        $endpoint = sprintf("%s/daily", $this->baseEndpoint());
        return $this->getObjects($endpoint, $query);
    }
}
