<?php

namespace Zoom;

/**
 * Class Billing
 * @package Zoom
 */
class Billing extends Resource
{
    /**
     * @var string resource base endpoint.
     */
    protected $endpoint = 'accounts';

    /**
     * @param string|null $accountId
     * @param string|null $endpoint
     * @param array|null $query
     * @return mixed
     */
    public function get(?string $accountId = null, ?string $endpoint = null, ?array $query = [])
    {
        if (empty($accountId)) {
            throw new \InvalidArgumentException('Account ID is invalid.');
        }
        $endpoint = sprintf("%s/%s/billing", $this->endpoint(), $accountId);
        return $this->get(null, $endpoint, $query);
    }
}
