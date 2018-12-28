<?php

namespace Zoom\Transformers;

use Psr\Http\Message\ResponseInterface;

/**
 * Class JsonTransformer
 * @package Zoom\Transformers
 */
class JsonTransformer implements Transformer
{
    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    public function transform(ResponseInterface $response)
    {
        return json_decode((string)$response->getBody());
    }
}