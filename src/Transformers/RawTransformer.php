<?php

namespace Zoom\Transformers;

use Psr\Http\Message\ResponseInterface;

/**
 * Class RawTransformer
 * @package Zoom\Transformers
 */
class RawTransformer implements Transformer
{
    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    public function transform(ResponseInterface $response)
    {
        return (string)$response->getBody();
    }
}