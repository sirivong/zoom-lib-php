<?php

namespace Zoom;

/**
 * Class Billing
 * @package Zoom
 */
class Billing extends Resource
{
    /**
     * @var string
     */
    protected $baseEndpoint = 'accounts';

    /**
     * @param string $accountId
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function getBilling(string $accountId)
    {
        $endpoint = sprintf("%s/%s/billing", $this->baseEndpoint(), $accountId);
        return $this->get($endpoint);
    }
}
