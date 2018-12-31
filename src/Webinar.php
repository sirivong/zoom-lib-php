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
     * @param string|null $endpoint
     * @param array|null $query
     * @return mixed
     */
    public function get(?string $userId = null, ?string $endpoint = null, ?array $query = [])
    {
        if (empty($userId)) {
            throw new \InvalidArgumentException('User ID or email is invalid.');
        }
        $endpoint = sprintf("%s/%s/webinars", $this->endpoint('users'), $userId);
        return parent::get(null, $endpoint, $query);
    }
}
