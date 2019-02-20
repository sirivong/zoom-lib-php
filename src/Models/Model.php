<?php

namespace Zoom\Models;

/**
 * Class Model
 * @package Zoom\Models
 */
abstract class Model
{
    /**
     * @param array $data
     * @return Model
     */
    abstract public function fromArray(array $data): Model;

    /**
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * @param object $data
     * @return Model
     */
    abstract public function fromJson(object $data): Model;

    /**
     * @return object
     */
    abstract public function toJson(): object;
}