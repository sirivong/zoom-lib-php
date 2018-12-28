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
     * @param int $meetingId
     * @param int $pageNumber
     * @param int $pageSize
     * @param null $occurrenceId
     * @param null $status
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function registrants(int $meetingId, int $pageNumber = 1, int $pageSize = 30, $occurrenceId = null, $status = null)
    {
        $endpoint = sprintf("%s/%s/registrants", $this->endpoint(), $meetingId);
        $query = [
            'page_number' => $pageNumber,
            'page_size' => $pageSize,
        ];
        if (!empty($occurrenceId)) {
            $query['occurrence_id'] = $occurrenceId;
        }
        if (!empty($status)) {
            $query['status'] = $status;
        }
        return $this->getObjects($endpoint, $query);
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
        return $this->put($endpoint, $query);
    }

    /**
     * @param int $meetingId
     * @param null $occurrenceId
     * @return mixed|object|\Psr\Http\Message\ResponseInterface|null
     * @throws \Exception
     */
    public function delete(int $meetingId, $occurrenceId = null)
    {
        $endpoint = sprintf("%s/%s", $this->endpoint(), $meetingId);
        $query = [];
        if (!empty($occurrenceId)) {
            $query = ['occurrence_id' => $occurrenceId];
        }
        return $this->delete($endpoint, $query);
    }
}
