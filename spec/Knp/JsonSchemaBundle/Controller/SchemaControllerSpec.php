<?php

namespace spec\Knp\JsonSchemaBundle\Controller;

use PhpSpec\ObjectBehavior;

class SchemaControllerSpec extends ObjectBehavior
{
    /**
     * @param \Knp\JsonSchemaBundle\Schema\SchemaRegistry               $registry
     * @param \Knp\JsonSchemaBundle\Schema\SchemaGenerator              $generator
     * @param \Symfony\Component\Routing\Router                         $router
     */
    function let($registry, $generator, $router)
    {
        $this->beConstructedWith($registry, $generator, $router);
    }

    /**
     * @param \Knp\JsonSchemaBundle\Model\Schema $schema
     */
    function its_showAction_displays_a_json_schema_with_according_content_type(
        $generator, $registry, $schema
    )
    {
        $generator->generate('foo')->willReturn($schema);

        $response = $this->showAction('foo');
        $response->shouldBeAnInstanceOf('Knp\JsonSchemaBundle\HttpFoundation\JsonSchemaResponse');
    }
}
