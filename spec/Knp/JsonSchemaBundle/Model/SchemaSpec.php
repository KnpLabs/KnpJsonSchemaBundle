<?php

namespace spec\Knp\JsonSchemaBundle\Model;

use PhpSpec\ObjectBehavior;

class SchemaSpec extends ObjectBehavior
{
    function it_should_have_a_title()
    {
        $this->setTitle('some schema');
        $this->getTitle()->shouldBe('some schema');
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

        $this->getProperties()->shouldBe(array('prop1' => $property1, 'prop2' => $property2));
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Property $property1
     */
    function it_should_be_serializable($property1)
    {
        $property1->getName()->willReturn('prop1');
        $property1->isRequired()->willReturn(true);
        $property1->jsonSerialize()->willReturn(array());

        $this->setTitle('some schema');
        $this->setType('object');
        $this->setSchema('http://json-schema.org/draft-04/schema#');
        $this->setId('http://example.com/schemas/user.json#');
        $this->addProperty($property1);

        $this->jsonSerialize()->shouldBe(
            array(
                'title'      => 'some schema',
                'type'       => 'object',
                '$schema'    => 'http://json-schema.org/draft-04/schema#',
                'id'         => 'http://example.com/schemas/user.json#',
                'properties' => array(
                    'prop1' => $property1
                ),
                'required' => array('prop1'),
            )
        );
    }

    function it_should_have_a_type_mutator()
    {
        $this->setType('object');
        $this->getType()->shouldReturn('object');
    }

    function it_should_have_a_schema_mutator()
    {
        $this->setSchema('http://json-schema.org/draft-04/schema#');
        $this->getSchema()->shouldReturn('http://json-schema.org/draft-04/schema#');
    }

    function it_should_have_an_id_mutator()
    {
        $this->setId('http://example.com/schemas/user.json#');
        $this->getId()->shouldReturn('http://example.com/schemas/user.json#');
    }
}
