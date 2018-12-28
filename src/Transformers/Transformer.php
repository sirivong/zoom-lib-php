<?php

namespace Zoom\Transformers;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface Transformer
 * @package Zoom\Transformers
 */
interface Transformer
{
    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    public function transform(ResponseInterface $response);
}