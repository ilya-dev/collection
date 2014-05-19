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

}
