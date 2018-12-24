<?php

namespace Zoom;

/**
 * Class Webinar
 * @package Zoom
 */
class Webinar extends Resource
{
    /**
     * @param int $webinarId
     * @return object|\Psr\Http\Message\ResponseInterface
     */
    public function getWebinar(int $webinarId)
    {
        return $this->getObject((string)$webinarId);
    }
}
