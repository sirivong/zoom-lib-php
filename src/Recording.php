<?php

namespace Zoom;

use Carbon\Carbon;

/**
 * Class Recording
 * @package Zoom
 */
class Recording extends Resource
{
    /**
     * @var string resource base endpoint.
     */
    protected $endpoint = 'recordings';

    /**
     * @param string $userId
     * @param $from
     * @param $to
     * @param array $query
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function recordings(string $userId, string $from, string $to, array $query = [])
    {
        $dateFrom = Carbon::parse($from)->format('Y-m-d');
        $dateTo = Carbon::parse($to)->format('Y-m-d');
        $query = array_merge($query, ['from' => $dateFrom, 'to' => $dateTo]);
        $endpoint = sprintf("%s/%s/recordings", $this->endpoint('users'), $userId);
        return $this->get(null, $endpoint, $query);
    }

    /**
     * @param string $meetingId
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function meetingRecordings(string $meetingId)
    {
        $query = [];
        $endpoint = sprintf("%s/%s/recordings", $this->endpoint('meetings'), $meetingId);
        return $this->get(null, $endpoint, $query);
    }
}
