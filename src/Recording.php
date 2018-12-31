<?php

namespace Zoom;

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
    public function recordings(string $userId, $from, $to, ?array $query = [])
    {
        if (is_a($from, \DateTime::class)) {
            $from = $from->format('Y-m-d');
        }
        if (is_a($to, \DateTime::class)) {
            $to = $to->format('Y-m-d');
        }
        $query = array_merge($query, ['from' => $from, 'to' => $to]);
        $endpoint = sprintf("%s/%s/recordings", $this->endpoint('users'), $userId);
        return $this->get(null, $endpoint, $query);
    }

    /**
     * @param string $meetingId
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function meetingRecordings(string $meetingId)
    {
        $endpoint = sprintf("%s/%s/recordings", $this->endpoint('meetings'), $meetingId);
        return $this->get(null, $endpoint);
    }
}
