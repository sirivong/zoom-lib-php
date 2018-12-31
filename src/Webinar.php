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
     * @param string|null $userId
     * @param array|null $query
     * @return mixed
     */
    public function getMany(?string $userId = null, ?array $query = [])
    {
        $endpoint = sprintf("%s/%s/webinars", $this->endpoint('users'), $userId);
        return $this->get(null, $endpoint, $query);
    }
}
