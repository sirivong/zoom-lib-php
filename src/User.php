<?php

namespace Zoom;

/**
 * Class User
 * @package Zoom
 */
class User extends Resource
{
    /**
     * @param int $pageNumber
     * @param int $pageSize
     * @param string|null $status
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function getUsers(int $pageNumber = 1, int $pageSize = 30, $status = null)
    {
        $query = !empty($status) ? ['status' => $status] : [];
        $query = $this->buildQuery($query, $pageNumber, $pageSize);
        return $this->getObjects(null, $query);
    }

    /**
     * @param string $userIdOrEmail
     * @param null $loginType
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function getUser(string $userIdOrEmail, $loginType = null)
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
    public function getMeetings(string $userIdOrEmail, $pageNumber = 1, $pageSize = 30)
    {
        $endpoint = sprintf("%s/%s/meetings", $this->baseEndpoint(), $userIdOrEmail);
        $query = $this->buildQuery(null, $pageNumber, $pageSize);
        return $this->getObjects($endpoint, $query);
    }

    /**
     * @param string $userIdOrEmail
     * @param int $pageNumber
     * @param int $pageSize
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function getWebinars(string $userIdOrEmail, $pageNumber = 1, $pageSize = 30)
    {
        $endpoint = sprintf("%s/%s/webinars", $this->baseEndpoint(), $userIdOrEmail);
        $query = $this->buildQuery(null, $pageNumber, $pageSize);
        return $this->getObjects($endpoint, $query);
    }

    /**
     * @param string $userIdOrEmail
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function getSettings(string $userIdOrEmail)
    {
        $endpoint = sprintf("%s/%s/settings", $this->baseEndpoint(), $userIdOrEmail);
        return $this->getObjects($endpoint);
    }

    /**
     * @param string $email
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function checkEmail(string $email)
    {
        $endpoint = sprintf("%s/email", $this->baseEndpoint());
        $query = [
            'query' => [
                'email' => $email
            ]
        ];
        $response = $this->httpClient->get($endpoint, $query);
        return $this->transformResponse($response);
    }
}
