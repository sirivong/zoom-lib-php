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
     * @param string $userIdOrEmail
     * @param $from
     * @param $to
     * @param array $options
     * $options = [
     *     'page_size' => 30,
     *     'nextPageToken' => null,
     *     'mc' => false,
     *     'trash' => false,
     * ];
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function getRecordings(string $userIdOrEmail, string $from, string $to, $options = [])
    {
        $dateFrom = Carbon::parse($from)->format('Y-m-d');
        $dateTo = Carbon::parse($to)->format('Y-m-d');
        $query = $this->buildQuery(array_merge(['from' => $dateFrom, 'to' => $dateTo], $options));
        $endpoint = sprintf("%s/%s/recordings", $this->endpoint('users'), $userIdOrEmail);
        return $this->getObjects($endpoint, $query);
    }

    /**
     * @param string $meetingId
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function getMeetingRecordings(string $meetingId)
    {
        $endpoint = sprintf("%s/%s/recordings", $this->endpoint('meetings'), $meetingId);
        return $this->getObjects($endpoint);
    }
}
