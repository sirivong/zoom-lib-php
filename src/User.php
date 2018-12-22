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
     * @param string|null $status
     * @param int $pageNumber
     * @param int $pageSize
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function listUsers(string $status = null, int $pageNumber = 1, int $pageSize = 30)
    {
        $options = [
            'query' => [
                'page_number' => $pageNumber,
                'page_size' => $pageSize,
            ]
        ];
        if (!empty($status)) {
            $option['query']['status'] = $status;
        }
        $response = $this->client->get($this->baseEndpoint(), $options);
        return $this->transformResponse($response);
    }

    /**
     * @param string $userId
     * @param null $loginType
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function retrieveUser(string $userId, $loginType = null)
    {
        $endpoint = sprintf("%s/%s", $this->baseEndpoint(), $userId);
        $options = [];
        if (!empty($loginType)) {
            $options['query'] = [
                'login_type' => $loginType
            ];
        }
        $response = $this->client->get($endpoint, $options);
        return $this->transformResponse($response);
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
     * @param string $userId
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function retrieveSettings(string $userId)
    {
        $endpoint = sprintf("%s/%s/settings", $this->baseEndpoint(), $userId);
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
