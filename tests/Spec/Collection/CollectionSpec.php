<?php namespace Spec\Collection;

use Collection\Collection;
use PhpSpec\ObjectBehavior;

class CollectionSpec extends ObjectBehavior {

    function let()
    {
        $this->beConstructedWith([1, 2, 3, 4, 5]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Collection\Collection');
    }

    function it_returns_all_items()
    {
        $this->all()->shouldReturn([1, 2, 3, 4, 5]);
    }

    function it_retrieves_a_value()
    {
        $this->get(4)->shouldReturn(5);

        $this->get(10)->shouldReturn(null);

        $this->get(10, false)->shouldReturn(false);
    }

    function it_pushes_a_value()
    {
        $this->push(6);

        $this->all()->shouldReturn([1, 2, 3, 4, 5, 6]);
    }

    function it_puts_a_value_by_key()
    {
        $this->put(5, 6);

        $this->all()->shouldReturn([1, 2, 3, 4, 5, 6]);
    }

    function it_checks_if_an_item_exists_by_key()
    {
        $this->has(4)->shouldReturn(true);

        $this->has(5)->shouldReturn(false);
    }

    function it_flattens_all_items()
    {
        $this->push([6, 7, [8, 9]]);

        $collection = $this->flatten();

        $collection->shouldBeCollection();
        $collection->all()->shouldReturn([1, 2, 3, 4, 5, 6, 7, 8, 9]);
    }

    function it_reverses_all_items()
    {
        $collection = $this->reverse();

        $collection->shouldBeCollection();
        $collection->all()->shouldReturn([5, 4, 3, 2, 1]);
    }

    function it_runs_iterator_over_each_of_the_items()
    {
        $iterator = function($item)
        {
            return 2 * $item;
        };

        $collection = $this->map($iterator);

        $collection->shouldBeCollection();
        $collection->all()->shouldReturn([2, 4, 6, 8, 10]);
    }

    function it_transforms_all_items()
    {
        $iterator = function($item)
        {
            return 2 * $item;
        };

        $this->transform($iterator);
        $this->all()->shouldReturn([2, 4, 6, 8, 10]);
    }

    function it_returns_only_unique_items()
    {
        $this->push(5);

        $collection = $this->unique();
        $collection->shouldBeCollection();
        $collection->all()->shouldReturn([1, 2, 3, 4, 5]);
    }

    function it_removes_an_item_by_key()
    {
        $this->remove(4);

        $this->all()->shouldReturn([1, 2, 3, 4]);
    }

    function it_resets_the_item_keys()
    {
        $this->remove(0);

        $items = [2, 3, 4, 5];

        $this->all()->shouldNotReturn($items);

        $this->values();

        $this->all()->shouldReturn($items);
    }

    function it_returns_and_removes_the_last_item()
    {
        $this->pop()->shouldReturn(5);
        $this->pop()->shouldReturn(4);

        $this->all()->shouldReturn([1, 2, 3]);

        $this->pop();
        $this->pop();
        $this->pop();

        $this->pop()->shouldReturn(null);
    }

    function it_is_json_serializable()
    {
        $this->shouldImplement('Collection\Contracts\JsonableContract');

        $this->jsonSerialize()->shouldBeEqualTo($this->all());

        $this->toJson()->shouldReturn('[1,2,3,4,5]');

        $this->toJson(JSON_PRETTY_PRINT)->shouldNotReturn('[1,2,3,4,5]');

        $this->toJson()->shouldBeLike($this->getWrappedObject());
    }

    function it_is_countable()
    {
        $this->shouldImplement('Countable');

        $this->count()->shouldReturn(5);

        $this->count()->shouldBeEqualTo(count($this->getWrappedObject()));
    }

    function it_is_traversable()
    {
        $this->shouldImplement('IteratorAggregate');

        $iterator = $this->getIterator();

        $iterator->shouldHaveType('ArrayIterator');
        $iterator->getArrayCopy()->shouldReturn([1, 2, 3, 4, 5]);
    }

    function it_supports_array_access()
    {
        $this->shouldImplement('ArrayAccess');

        $collection = $this->getWrappedObject();

        $this->get(3)->shouldReturn($collection[3]);

        $collection[] = 6;
        $this->all()->shouldReturn([1, 2, 3, 4, 5, 6]);

        $collection[5] = 10;
        $this->all()->shouldReturn([1, 2, 3, 4, 5, 10]);

        $this->has(5)->shouldBeEqualTo(isset ($collection[5]));
        $this->has(6)->shouldBeEqualTo(isset ($collection[6]));

        unset ($collection[5]);
        $this->all()->shouldReturn([1, 2, 3, 4, 5]);
    }

    /**
     * Get inline matchers.
     *
     * @return array
     */
    public function getMatchers()
    {
        return [
            'beCollection' => function($subject)
            {
                return ($subject instanceof Collection);
            }
        ];
    }

}
