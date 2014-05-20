<?php namespace Collection;

use Collection\Contracts\JsonableContract;
use Countable;
use IteratorAggregate, ArrayIterator;
use ArrayAccess;

class Collection implements JsonableContract, Countable, IteratorAggregate, ArrayAccess {

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
     * Count the number of items.
     *
     * @return integer
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Get an iterator for the items.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Unset the item at a given offset.
     *
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {

    }

    /**
     * Determine whether an item exists at a given offset.
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {

    }

    /**
     * Set the item at a given offset.
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {

    }

    /**
     * Get an item at a given offset.
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {

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

    /**
     * Convert the object into a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

}
