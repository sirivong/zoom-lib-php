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
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function settings(string $userId, ?array $query = [])
    {
        $endpoint = sprintf("%s/%s/settings", $this->endpoint(), $userId);
        return $this->get(null, $endpoint, $query);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function emailExisted(string $email): bool
    {
        if (($email = filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
            throw new \InvalidArgumentException("Invalid email address: ${email}");
        }
        $endpoint = sprintf("%s/email", $this->endpoint());
        $query = ['email' => $email];
        return $this->get(null, $endpoint, $query)->existed_email;
    }
}
