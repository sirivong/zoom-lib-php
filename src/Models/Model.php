<?php

namespace Zoom\Models;

/**
 * Class Model
 * @package Zoom\Models
 */
abstract class Model
{
    /**
     * @return array
     */
    abstract public function toArray(): array;
}