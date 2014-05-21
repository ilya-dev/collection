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

    function it_checks_if_the_collection_is_empty()
    {
        $this->isEmpty()->shouldReturn(false);

        // invoke "pop" 5 times
        array_map([$this, 'pop'], range(1, 5));

        $this->isEmpty()->shouldReturn(true);
    }

    function it_returns_an_array_with_the_values_of_a_key()
    {
        // clean the collection
        array_map([$this, 'remove'], range(0, 4));

        $this->push(['name' => 'Jack']);
        $this->push(['name' => 'John']);

        $this->pluck('name')->shouldReturn(['Jack', 'John']);
    }

    function it_merges_the_collection_with_given_items()
    {
        $collection = $this->merge([6, 7, 8]);

        $collection->shouldBeCollection();
        $collection->all()->shouldReturn([1, 2, 3, 4, 5, 6, 7, 8]);

        $collection = $this->merge(new Collection([6, 7, 8]));

        $collection->shouldBeCollection();
        $collection->all()->shouldReturn([1, 2, 3, 4, 5, 6, 7, 8]);
    }

    function it_prepends_an_item()
    {
        $this->prepend(0);

        $this->all()->shouldReturn([0, 1, 2, 3, 4, 5]);
    }

    function it_returns_and_removes_the_first_item()
    {
        $this->shift()->shouldReturn(1);
        $this->shift()->shouldReturn(2);
        $this->shift()->shouldReturn(3);

        $this->all()->shouldReturn([4, 5]);

        $this->shift();
        $this->shift();

        $this->shift()->shouldReturn(null);
    }

    function it_runs_a_filter_over_each_of_the_items()
    {
        $filter = function($item)
        {
            return ($item % 2) == 0;
        };

        $collection = $this->filter($filter);
        $collection->shouldBeCollection();
        $collection->all()->shouldReturn([1 => 2, 3 => 4]);
    }

    function it_runs_an_iterator_over_each_of_the_items()
    {
        $iterator = function($item)
        {
            // do something with the item...
        };

        $this->each($iterator);
    }

    function it_computes_the_difference_between_two_sets_of_items()
    {
        $collection = $this->difference([1, 2, 3]);
        $collection->shouldBeCollection();
        $collection->all()->shouldReturn([3 => 4, 4 => 5]);

        $this->difference(new Collection([1, 2, 3]))->shouldBeLike($collection);
    }

    function it_computes_intersection_of_two_sets_of_items()
    {
        $collection = $this->intersection([1, 2, 10]);
        $collection->shouldBeCollection();
        $collection->all()->shouldReturn([1, 2]);

        $this->intersection(new Collection([1, 2, 10]))->shouldBeLike($collection);
    }

    function it_reduces_the_collection_to_a_single_value()
    {
        $callback = function($previous, $current)
        {
            return $previous + $current;
        };

        $this->reduce($callback)->shouldReturn(15);
    }

    function it_returns_the_sum_of_the_items()
    {
        $this->sum()->shouldReturn(15);

        $callback = function($item)
        {
            return $item * 2;
        };

        $this->sum($callback)->shouldReturn(30);
    }

    function it_randomly_picks_items_from_the_collection()
    {
        $this->random()->shouldBeInteger();

        $items = $this->random(2);
        $items->shouldBeArray();
        $items->shouldHaveCount(2);
    }

    function it_concatenates_items()
    {
        // clean the collection
        array_map([$this, 'pop'], range(1, 5));

        $this->push(['message' => 'Hello']);
        $this->push(['message' => 'world']);

        $this->implode('message')->shouldReturn('Helloworld');
        $this->implode('message', ', ')->shouldReturn('Hello, world');
    }

    function it_groups_an_array_by_a_field_value()
    {
        // clean the collection
        array_map([$this, 'pop'], range(1, 5));

        $this->push(['value' => 'foo']);
        $this->push(['value' => 'bar']);

        $collection = $this->groupBy('value');

        $collection->shouldBeCollection();
        $collection->all()->shouldReturn([
            'foo' => [
                [
                    'value' => 'foo'
                ]
            ],
            'bar' => [
                [
                    'value' => 'bar'
                ]
            ]
        ]);
    }

    function it_collapses_the_items_into_a_single_array()
    {
        // clean the collection
        array_map([$this, 'pop'], range(1, 5));

        $this->push([1, 2]);
        $this->push([3, 4]);

        $collection = $this->collapse();
        $collection->shouldBeCollection();
        $collection->all()->shouldReturn([1, 2, 3, 4]);
    }

    function it_returns_the_first_item()
    {
        $this->first()->shouldReturn(1);

        // clean the collection
        array_map([$this, 'pop'], range(1, 5));

        $this->first()->shouldReturn(null);
    }

    function it_returns_the_last_item()
    {
        $this->last()->shouldReturn(5);

        // clean the collection
        array_map([$this, 'pop'], range(1, 5));

        $this->last()->shouldReturn(null);
    }

    function it_slices_the_underlying_array_of_items()
    {
        $this->slice(1)->all()->shouldReturn([2, 3, 4, 5]);

        $this->slice(1, 2)->all()->shouldReturn([2, 3]);

        $this->slice(1, 2, true)->all()->shouldReturn([1 => 2, 2 => 3]);
    }

    function it_splices_portion_of_the_underlying_array()
    {
        $this->splice(0, 2)->all()->shouldReturn([1, 2]);
    }

    function it_fetches_a_nested_element()
    {
        $this->put('foo', ['bar' => ['baz' => 42]]);

        $this->fetch('foo.bar')->all()->shouldReturn(['baz' => 42]);
    }

    function it_returns_a_number_of_the_items()
    {
        $this->take(3)->all()->shouldReturn([1, 2, 3]);

        $this->take(-3)->all()->shouldReturn([3, 4, 5]);
    }

    function it_splits_the_underlying_array_into_chunks()
    {
        $this->chunk(2)->all()->shouldHaveCount(3);
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
