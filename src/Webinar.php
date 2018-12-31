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
    public function getMany(string $userId, ?array $query = [])
    {
        if (empty($userId)) {
            throw new \InvalidArgumentException('User ID or email is invalid.');
        }
        $endpoint = sprintf("%s/%s/webinars", $this->endpoint('users'), $userId);
        return parent::get(null, $endpoint, $query);
    }

    /**
     * @param string $webinarId
     * @return mixed
     */
    public function getOne(string $webinarId)
    {
        return parent::get($webinarId);
    }
}
