<?php namespace Spec\Collection;

use PhpSpec\ObjectBehavior;

class CollectionSpec extends ObjectBehavior {

    function it_is_initializable()
    {
        $this->shouldHaveType('Collection\Collection');
    }

}
