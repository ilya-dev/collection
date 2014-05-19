<?php namespace Collection;

class Collection {

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

}
