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
     * @param int $pageSize
     * @param int $pageNumber
     * @return \Psr\Http\Message\ResponseInterface|object
     */
    public function listUsers(string $status = null, int $pageSize = 50, int $pageNumber = 1)
    {
        $options = [
            'page_size' => $pageSize,
            'page_number' => $pageNumber,
        ];
        if (!empty($status)) {
            $options['status'] = $status;
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
            $options['login_type'] = $loginType;
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
            'page_number' => $pageNumber,
            'page_size' => $pageSize,
        ];
        $response = $this->client->get($endpoint, $options);
        return $this->transformResponse($response);
    }
}
