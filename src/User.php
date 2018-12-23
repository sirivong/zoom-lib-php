<?php

namespace Zoom;

/**
 * Class User
 * @package Zoom
 */
class User extends ZoomObject
{
    /**
     * @param int $pageNumber
     * @param int $pageSize
     * @param string|null $status
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function getUsers(int $pageNumber = 1, int $pageSize = 30, $status = null)
    {
        $options = !empty($status) ? ['status' => $status] : [];
        return $this->getObjects($pageNumber, $pageSize, $options);
    }

    /**
     * @param string $userIdOrEmail
     * @param null $loginType
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function getUserByIdOrEmail(string $userIdOrEmail, $loginType = null)
    {
        $options = !empty($loginType) ? ['login_type' => $loginType] : [];
        return $this->getObjectById($userIdOrEmail, $options);
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
        return $this->getObjects($pageNumber, $pageSize, null, $endpoint);
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
        return $this->getObjects($pageNumber, $pageSize, null, $endpoint);
    }

    /**
     * @param string $userIdOrEmail
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function getSettings(string $userIdOrEmail)
    {
        $endpoint = sprintf("%s/%s/settings", $this->baseEndpoint(), $userIdOrEmail);
        $response = $this->client->get($endpoint);
        return $this->transformResponse($response);
    }

    /**
     * @param string $email
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function checkEmail(string $email)
    {
        $endpoint = sprintf("%s/email", $this->baseEndpoint());
        $options = [
            'query' => [
                'email' => $email
            ]
        ];
        $response = $this->client->get($endpoint, $options);
        return $this->transformResponse($response);
    }
}
