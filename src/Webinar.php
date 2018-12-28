<?php

namespace Zoom;

/**
 * Class Webinar
 * @package Zoom
 */
class Webinar extends Resource
{
    /**
     * @var string resource base endpoint.
     */
    protected $endpoint = 'webinars';

    /**
     * @param int $webinarId
     * @return object|\Psr\Http\Message\ResponseInterface
     */
    public function webinar(int $webinarId)
    {
        return $this->getObject((string)$webinarId);
    }
}
