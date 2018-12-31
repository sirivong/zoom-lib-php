<?php

namespace Zoom;

/**
 * Class User
 * @package Zoom
 */
class User extends Resource
{
    /**
     * @var string resource base endpoint.
     */
    protected $endpoint = 'users';

    /**
     * @param string $userId
     * @param array $query
     * @return \Psr\Http\Message\ResponseInterface|object
     * public function meetings(string $userId, array $query = [])
     * {
     * $endpoint = sprintf("%s/%s/meetings", $this->endpoint(), $userId);
     * return $this->list($query, $endpoint);
     * }
     */

    /**
     * @param string $userId
     * @param array $query
     * @return \Psr\Http\Message\ResponseInterface|object
     * public function webinars(string $userId, array $query = [])
     * {
     * $endpoint = sprintf("%s/%s/webinars", $this->endpoint(), $userId);
     * return $this->list($query, $endpoint);
     * }
     */

    /**
     * @param string $userId
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function settings(string $userId, ?array $query = [])
    {
        $endpoint = sprintf("%s/%s/settings", $this->endpoint(), $userId);
        return $this->get(null, $endpoint, $query);
    }

    /**
     * @param string $email
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function checkEmail(string $email)
    {
        $endpoint = sprintf("%s/email", $this->endpoint());
        $query = ['email' => $email];
        return $this->get(null, $endpoint, $query);
    }
}
