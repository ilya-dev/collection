<?php namespace Collection\Contracts;

use JsonSerializable;

interface JsonableContract extends JsonSerializable {

    /**
     * Get the collection as JSON.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0);

}
