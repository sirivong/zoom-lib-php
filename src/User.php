<?php

namespace Zoom;

/**
 * Class User
 * @package Zoom
 */
class User extends ZoomObject
{
    /**
     * @var string
     */
    protected $baseEndpointUri = 'users';

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
     * @param string $userId
     * @param int $pageNumber
     * @param int $pageSize
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function listMeetings(string $userId, $pageNumber = 1, $pageSize = 30)
    {
        $endpoint = sprintf("%s/%s/meetings", $this->baseEndpoint(), $userId);
        $options = [
            'query' => [
                'page_number' => $pageNumber,
                'page_size' => $pageSize,
            ]
        ];
        $response = $this->client->get($endpoint, $options);
        return $this->transformResponse($response);
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
