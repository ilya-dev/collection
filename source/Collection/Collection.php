<?php namespace Collection;

use Collection\Contracts\JsonableContract;
use Countable;
use IteratorAggregate, ArrayIterator;
use ArrayAccess;
use Closure;

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
     * Get an item by key.
     *
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->items) ? $this->items[$key] : $default;
    }

    /**
     * Push a value onto the end.
     *
     * @param mixed $value
     * @return void
     */
    public function push($value)
    {
        $this->items[] = $value;
    }

    /**
     * Put a value by key.
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function put($key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * Determine whether an item exists by key.
     *
     * @param mixed $key
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Flatten all items in the collection and return a new one.
     *
     * @return Collection
     */
    public function flatten()
    {
        $items = [];

        foreach ($this->items as $item)
        {
            if (is_array($item))
            {
                $items = array_merge($items, (new static($item))->flatten()->all());

                continue;
            }

            $items[] = $item;
        }

        return new static($items);
    }

    /**
     * Reverse all items and wrap them into a Collection instance.
     *
     * @return Collection
     */
    public function reverse()
    {
        return new static(array_reverse($this->items));
    }

    /**
     * Run iterator over each of the items.
     *
     * @param Closure $iterator
     * @return Collection
     */
    public function map(Closure $iterator)
    {
        return new static(array_map($iterator, $this->items));
    }

    /**
     * Transform the items using iterator.
     *
     * @param Closure $iterator
     * @return void
     */
    public function transform(Closure $iterator)
    {
        $this->items = array_map($iterator, $this->items);
    }

    /**
     * Get only unique items.
     *
     * @return Collection
     */
    public function unique()
    {
        return new static(array_unique($this->items));
    }

    /**
     * Remove an item by key.
     *
     * @param mixed $key
     * @return void
     */
    public function remove($key)
    {
        unset ($this->items[$key]);
    }

    /**
     * Reset the keys.
     *
     * @return void
     */
    public function values()
    {
        $this->items = array_values($this->items);
    }

    /**
     * Get and remove the last item.
     *
     * @return mixed|null
     */
    public function pop()
    {
        return array_pop($this->items);
    }

    /**
     * Determine if the collection has no items.
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return count($this->items) == 0;
    }

    /**
     * Get an array with the values of a key.
     *
     * @param mixed $key
     * @return array
     */
    public function pluck($key)
    {
        $items = [];

        foreach ($this->items as $item)
        {
            $items[] = $item[$key];
        }

        return $items;
    }

    /**
     * Merge the collection with given array/collection.
     *
     * @param Collection|array $items
     * @return Collection
     */
    public function merge($items)
    {
        return new static(array_merge($this->items, $this->toArray($items)));
    }

    /**
     * Push an item onto the beginning.
     *
     * @param mixed $value
     * @return void
     */
    public function prepend($value)
    {
        array_unshift($this->items, $value);
    }

    /**
     * Get and remove the first item.
     *
     * @return mixed|null
     */
    public function shift()
    {
        return array_shift($this->items);
    }

    /**
     * Run a filter over each of the items.
     *
     * @param Closure $filter
     * @return Collection
     */
    public function filter(Closure $filter)
    {
        return new static(array_filter($this->items, $filter));
    }

    /**
     * Run an iterator over each of the items.
     *
     * @param Closure $iterator
     * @return void
     */
    public function each(Closure $iterator)
    {
        array_map($iterator, $this->items);
    }

    /**
     * Find the difference between two sets of items.
     *
     * @param Collection|array $items
     * @return Collection
     */
    public function difference($items)
    {
        return new static(array_diff($this->items, $this->toArray($items)));
    }

    /**
     * Compute intersection of two sets of items.
     *
     * @param Collection|array $items
     * @return Collection
     */
    public function intersection($items)
    {
        return new static(array_intersect($this->items, $this->toArray($items)));
    }

    /**
     * Reduce the collection to a single value.
     *
     * @param Closure $callback
     * @param mixed $initial
     * @return mixed
     */
    public function reduce(Closure $callback, $initial = null)
    {
        return array_reduce($this->items, $callback, $initial);
    }

    /**
     * Get the sum of the items.
     *
     * @param Closure|null $callback
     * @return mixed
     */
    public function sum(Closure $callback = null)
    {
        if (is_null($callback))
        {
            $callback = function($item)
            {
                return $item;
            };
        }

        return $this->reduce(function($previous, $current) use($callback)
        {
            return $previous + $callback($current);
        }, 0);
    }

    /**
     * Randomly pick one or more items.
     *
     * @param integer $amount
     * @return mixed
     */
    public function random($amount = 1)
    {
        $keys = array_rand($this->items, $amount);

        return is_array($keys) ? array_intersect_key($this->items, array_flip($keys)) : $this->items[$keys];
    }

    /**
     * Concatenate items of a key.
     *
     * @param string $key
     * @param string $glue
     * @return string
     */
    public function implode($key, $glue = '')
    {
        return implode($glue, $this->pluck($key));
    }

    /**
     * Group an array by a field value.
     *
     * @param string $key
     * @return Collection
     */
    public function groupBy($key)
    {
        $groups = [];

        foreach ($this->items as $itemKey => $value)
        {
            $groups[$value[$key]][] = $value;
        }

        return new static($groups);
    }

    /**
     * Collapse the items into a single array.
     *
     * @return Collection
     */
    public function collapse()
    {
        $items = [];

        foreach ($this->items as $item)
        {
            $items = array_merge($items, $item);
        }

        return new static($items);
    }

    /**
     * Get the first item.
     *
     * @return mixed|null
     */
    public function first()
    {
        return count($this->items) ? reset($this->items) : null;
    }

    /**
     * Get the last item.
     *
     * @return mixed|null
     */
    public function last()
    {
        return count($this->items) ? end($this->items) : null;
    }

    /**
     * Slice the underlying array.
     *
     * @param integer $offset
     * @param integer $length
     * @param boolean $preserveKeys
     * @return Collection
     */
    public function slice($offset, $length = null, $preserveKeys = false)
    {
        return new static(
            array_slice($this->items, $offset, $length, $preserveKeys)
        );
    }

    /**
     * Splice portion of the underlying array.
     *
     * @param integer $offset
     * @param integer $length
     * @param mixed $replacement
     * @return Collection
     */
    public function splice($offset, $length = 0, $replacement = [])
    {
        return new static(
            array_splice($this->items, $offset, $length, $replacement)
        );
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
        unset ($this->items[$offset]);
    }

    /**
     * Determine whether an item exists at a given offset.
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
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
        if (is_null($offset))
        {
            $this->items[] = $value;

            return null;
        }

        $this->items[$offset] = $value;
    }

    /**
     * Get an item at a given offset.
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
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

    /**
     * Get array of items.
     *
     * @param Collection|array $items
     * @return array
     */
    protected function toArray($items)
    {
        if ($items instanceof static)
        {
            return $items->all();
        }

        return $items;
    }

}
