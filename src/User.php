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
     * @param int $pageNumber
     * @param int $pageSize
     * @param string|null $status
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function users(int $pageNumber = 1, int $pageSize = 30, $status = null)
    {
        $query = [
            'page_number' => $pageNumber,
            'page_size' => $pageSize,
            'status' => $status,
        ];
        return $this->getObjects(null, $this->buildQuery($query));
    }

    /**
     * @param string $userIdOrEmail
     * @param null $loginType
     * @return object|\Psr\Http\Message\ResponseInterface|null
     * @throws \Exception
     */
    public function user(string $userIdOrEmail, $loginType = null)
    {
        $query = !empty($loginType) ? ['login_type' => $loginType] : [];
        return $this->getObject($userIdOrEmail, $query);
    }

    /**
     * @param string $userIdOrEmail
     * @param int $pageNumber
     * @param int $pageSize
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function meetings(string $userIdOrEmail, $pageNumber = 1, $pageSize = 30)
    {
        $endpoint = sprintf("%s/%s/meetings", $this->endpoint(), $userIdOrEmail);
        $query = $this->buildQuery(['page_number' => $pageNumber, 'page_size' => $pageSize]);
        return $this->getObjects($endpoint, $query);
    }

    /**
     * @param string $userIdOrEmail
     * @param int $pageNumber
     * @param int $pageSize
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function webinars(string $userIdOrEmail, $pageNumber = 1, $pageSize = 30)
    {
        $endpoint = sprintf("%s/%s/webinars", $this->endpoint(), $userIdOrEmail);
        $query = $this->buildQuery(['page_number' => $pageNumber, 'page_size' => $pageSize]);
        return $this->getObjects($endpoint, $query);
    }

    /**
     * @param string $userIdOrEmail
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function settings(string $userIdOrEmail)
    {
        $endpoint = sprintf("%s/%s/settings", $this->endpoint(), $userIdOrEmail);
        return $this->getObjects($endpoint);
    }

    /**
     * @param string $email
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function checkEmail(string $email)
    {
        $endpoint = sprintf("%s/email", $this->endpoint());
        $query = [
            'query' => [
                'email' => $email
            ]
        ];
        $response = $this->httpClient->get($endpoint, $query);
        return $this->transform($response);
    }
}
