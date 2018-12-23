<?php

namespace Zoom;

/**
 * Class Meeting
 * @package Zoom
 */
class Meeting extends ZoomObject
{
    /**
     * @param int $meetingId
     * @param int $pageNumber
     * @param int $pageSize
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function getRegistrants(int $meetingId, int $pageNumber = 1, int $pageSize = 30)
    {
        $endpoint = sprintf("%s/%s/registrants", $this->baseEndpoint(), $meetingId);
        $options = [
            'page_number' => $pageNumber,
            'page_size' => $pageSize,
        ];
        $response = $this->client->get($endpoint, $options);
        return $this->transformResponse($response);
    }
}
