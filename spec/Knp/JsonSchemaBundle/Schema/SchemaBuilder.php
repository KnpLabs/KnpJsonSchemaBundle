<?php

namespace spec\Knp\JsonSchemaBundle\Schema;

use PHPSpec2\ObjectBehavior;

class SchemaBuilder extends ObjectBehavior
{
    /**
     * @param Knp\JsonSchemaBundle\Property\PropertyHandlerInterface $handler1
     * @param Knp\JsonSchemaBundle\Property\PropertyHandlerInterface $handler2
     * @param Knp\JsonSchemaBundle\Property\PropertyHandlerInterface $handler3
     */
    function let($handler1, $handler2, $handler3)
    {
        $this->registerPropertyHandler($handler1, 3);
        $this->registerPropertyHandler($handler2, 1);
        $this->registerPropertyHandler($handler3, 2);
    }

    function it_should_be_able_to_register_property_handlers()
    {
        $this->getPropertyHandlers()->shouldHaveCount(3);
    }

    function it_should_be_able_to_register_property_handlers_orderly($handler1, $handler2, $handler3)
    {
        $this->getPropertyHandlers()->shouldBe([$handler1, $handler3, $handler2]);
    }
}
