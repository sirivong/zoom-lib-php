<?php

namespace Zoom;

/**
 * Class Report
 * @package Zoom
 */
class Report extends Resource
{
    /**
     * @var string resource base endpoint.
     */
    protected $endpoint = 'report';

    /**
     * @param int $month
     * @param int $year
     * @return mixed
     * @throws \Exception
     */
    public function dailyReport(int $month = -1, int $year = -1)
    {
        if (!($month && $year)) {
            $now = new \DateTime('now');
            $month = $now->month;
            $year = $now->year;
        }
        $query = [
            'month' => $month,
            'year' => $year,
        ];
        $endpoint = sprintf("%s/daily", $this->endpoint());
        return $this->get(null, $endpoint, $query);
    }
}
