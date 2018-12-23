<?php

namespace Zoom;

/**
 * Class Webinar
 * @package Zoom
 */
class Webinar extends ZoomObject
{
    /**
     * @param int $webinarId
     * @return object|\Psr\Http\Message\ResponseInterface
     */
    public function getWebinarById(int $webinarId)
    {
        return $this->getObjectById((string)$webinarId);
    }
}
