<?php

namespace spec\Knp\JsonSchemaBundle\Schema;

use PHPSpec2\ObjectBehavior;

class SchemaBuilder extends ObjectBehavior
{
    /**
     * @param Knp\JsonSchemaBundle\Constraints\ConstraintHandlerInterface $handler1
     * @param Knp\JsonSchemaBundle\Constraints\ConstraintHandlerInterface $handler2
     * @param Knp\JsonSchemaBundle\Constraints\ConstraintHandlerInterface $handler3
     */
    function let($handler1, $handler2, $handler3)
    {
        $this->registerConstraintHandler($handler1, 3);
        $this->registerConstraintHandler($handler2, 1);
        $this->registerConstraintHandler($handler3, 2);
    }

    function it_should_be_able_to_register_constraint_handlers()
    {
        $this->getConstraintHandlers()->shouldHaveCount(3);
    }

    function it_should_be_able_to_register_constraint_handlers_orderly($handler1, $handler2, $handler3)
    {
        $this->getConstraintHandlers()->shouldBe([$handler1, $handler3, $handler2]);
    }
}
