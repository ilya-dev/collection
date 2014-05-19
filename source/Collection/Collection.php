<?php namespace Collection;

use Collection\Contracts\JsonableContract;

class Collection implements JsonableContract {

    /**
     * The items stored.
     *
     * @var array
     */
    protected $items = [];

    /**
     * The constructor.
     *
     * @param array $items
     * @return Collection
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Get all of the items.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Convert the object into a serializable structure.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->items;
    }

    /**
     * Get the collection as JSON.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->items, $options);
    }

}
