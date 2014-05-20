<?php namespace Spec\Collection;

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

        // TODO: write more tests
    }

}
