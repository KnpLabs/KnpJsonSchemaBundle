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

    /**
     * @param Symfony\Component\Validator\Mapping\PropertyMetadata $propertyMetadata
     * @param Symfony\Component\Validator\Constraint $constraint
     */
    function it_should_apply_all_constraint_handlers_on_each_properties($handler1, $handler2, $handler3, $propertyMetadata, $constraint)
    {
        $propertyMetadata->constraints = [$constraint];

        $handler1->handle(ANY_ARGUMENTS)->shouldBeCalled();
        $handler2->handle(ANY_ARGUMENTS)->shouldBeCalled();
        $handler3->handle(ANY_ARGUMENTS)->shouldBeCalled();

        $this->addProperty($propertyMetadata);
    }

    /**
     * @param Symfony\Component\Validator\Mapping\PropertyMetadata $propertyMetadata
     * @param Symfony\Component\Validator\Constraint $constraint
     */
    function it_should_check_if_constraint_handler_support_constraint_before_calling_the_handle_mecanism($handler1, $handler2, $handler3, $propertyMetadata, $constraint)
    {
        $propertyMetadata->constraints = [$constraint];

        $handler1->supports($constraint)->shouldBeCalled();
        $handler2->supports($constraint)->shouldBeCalled();
        $handler3->supports($constraint)->shouldBeCalled();

        $this->addProperty($propertyMetadata);
    }
}
