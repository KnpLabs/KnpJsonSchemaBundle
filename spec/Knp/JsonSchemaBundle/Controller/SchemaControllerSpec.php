<?php

namespace spec\Knp\JsonSchemaBundle\Controller;

use PhpSpec\ObjectBehavior;

class SchemaControllerSpec extends ObjectBehavior
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param \Knp\JsonSchemaBundle\Schema\SchemaGenerator              $generator
     */
    function let($container, $generator, $registry)
    {
        $container->get('json_schema.generator')->willReturn($generator);

        $this->setContainer($container);
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
