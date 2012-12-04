<?php

namespace spec\Knp\JsonSchemaBundle\Model;

use PHPSpec2\ObjectBehavior;

class Schema extends ObjectBehavior
{
    function it_should_have_a_name()
    {
        $this->setName('some schema');
        $this->getName()->shouldBe('some schema');
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Property $property1
     * @param Knp\JsonSchemaBundle\Model\Property $property2
     */
    function it_should_have_properties($property1, $property2)
    {
        $property1->getName()->willReturn('prop1');
        $property2->getName()->willReturn('prop2');

        $this->addProperty($property1);
        $this->addProperty($property2);

        $this->getProperties()->shouldBe(['prop1' => $property1, 'prop2' => $property2]);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Property $property1
     */
    function it_should_serialze_its_name_and_its_properties($property1)
    {
        $property1->getName()->willReturn('prop1');
        $property1->jsonSerialize()->willReturn([]);

        $this->setName('some schema');
        $this->addProperty($property1);

        $this->jsonSerialize()->shouldBe(
            [
                'name' => 'some schema',
                'properties' => [
                    'prop1' => $property1
                ]
            ]
        );
    }
}
