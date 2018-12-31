<?php

namespace Zoom;

/**
 * Class Meeting
 * @package Zoom
 */
class Meeting extends Resource
{
    /**
     * @var string resource base endpoint.
     */
    protected $endpoint = 'meetings';

    /**
     * @param string|null $userId
     * @param string|null $endpoint
     * @param array|null $query
     * @return mixed
     */
    public function get(?string $userId = null, ?string $endpoint = null, ?array $query = [])
    {
        $endpoint = sprintf("%s/%s/meetings", $this->endpoint('users'), $userId);
        return parent::get(null, $endpoint, $query);
    }

    /**
     * @param string $meetingId
     * @param array $query
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function registrants(string $meetingId, array $query = [])
    {
        $endpoint = sprintf("%s/%s/registrants", $this->endpoint(), $meetingId);
        return $this->get(null, $endpoint, $query);
    }

    /**
     * @param int $meetingId
     * @return object|\Psr\Http\Message\ResponseInterface|null
     * @throws \Exception
     */
    public function end(int $meetingId)
    {
        $endpoint = sprintf("%s/%s/status", $this->endpoint(), $meetingId);
        $query = ['action' => 'end'];
        return $this->zoom->put($endpoint, $query);
    }

    /**
     * @param string $meetingId
     * @param null $occurrenceId
     * @return mixed|object|\Psr\Http\Message\ResponseInterface|null
     * @throws \Exception
     */
    public function delete(string $meetingId, $occurrenceId = null)
    {
        $endpoint = sprintf("%s/%s", $this->endpoint(), $meetingId);
        $query = ['occurrence_id' => $occurrenceId];
        return $this->zoom->delete($endpoint, $query);
    }
}
