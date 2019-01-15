<?php

namespace Zoom\Models;

/**
 * Class BaseModel
 * @package Zoom\Models
 */
class BaseModel
{
    /**
     * @param array $data
     * @return Model
     */
    public function fromArray(array $data): Model
    {
        $class = __CLASS__;
        return new $class();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @param object $data
     * @return Model
     */
    public function fromJson(object $data): Model
    {
        $class = __CLASS__;
        return new $class();
    }

    /**
     * @return object
     */
    public function toJson(): object
    {
        return (object)[];
    }
}