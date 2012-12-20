<?php

namespace spec\Knp\JsonSchemaBundle\Controller;

use PHPSpec2\ObjectBehavior;

class SchemaController extends ObjectBehavior
{
    /**
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param Knp\JsonSchemaBundle\Schema\SchemaGenerator              $schemaGenerator
     */
    function let($container, $schemaGenerator)
    {
        $container->get('json_schema.generator')->willReturn($schemaGenerator);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Schema          $schema
     * @param Knp\JsonSchemaBundle\Schema\SchemaRegistry $registry
     */
    function its_showAction_should_display_a_json_schema_with_according_content_type(
        $schemaGenerator, $registry, $schema
    )
    {
        $registry->get('foo')->willReturn('App\\Entity\\User');
        $schemaGenerator->generate('App\\Entity\\User')->willReturn($schema);

        $response = $this->showAction('foo');
        $response->getContent()->shouldReturn($schema);
        $response->shouldBeAnInstanceOf('Knp\JsonSchemaBundle\HttpFoundation\JsonSchemaResponse');
    }
}
