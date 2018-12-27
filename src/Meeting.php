<?php

namespace Zoom;

/**
 * Class Meeting
 * @package Zoom
 */
class Meeting extends Resource
{
    /**
     * @param int $meetingId
     * @param int $pageNumber
     * @param int $pageSize
     * @param null $occurrenceId
     * @param null $status
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function getRegistrants(int $meetingId, int $pageNumber = 1, int $pageSize = 30, $occurrenceId = null, $status = null)
    {
        $endpoint = sprintf("%s/%s/registrants", $this->baseEndpoint(), $meetingId);
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

    public function endMeeting(int $meetingId)
    {
        $endpoint = sprintf("%s/%s/status", $this->baseEndpoint(), $meetingId);
        $query = ['action' => 'end'];
        return $this->delete($endpoint, $query);

    }
}
