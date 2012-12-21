<?php

namespace spec\Knp\JsonSchemaBundle\Controller;

use PHPSpec2\ObjectBehavior;

class SchemaController extends ObjectBehavior
{
    /**
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param Knp\JsonSchemaBundle\Schema\SchemaGenerator              $generator
     * @param Knp\JsonSchemaBundle\Schema\SchemaRegistry               $registry
     */
    function let($container, $generator, $registry)
    {
        $container->get('json_schema.generator')->willReturn($generator);
        $container->get('json_schema.registry')->willReturn($registry);

        $this->setContainer($container);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Schema          $schema
     */
    function its_showAction_should_display_a_json_schema_with_according_content_type(
        $generator, $registry, $schema
    )
    {
        $registry->getNamespace('foo')->willReturn('App\\Entity\\User');
        $generator->generate('App\\Entity\\User')->willReturn($schema);

        $response = $this->showAction('foo');
        $response->shouldBeAnInstanceOf('Knp\JsonSchemaBundle\HttpFoundation\JsonSchemaResponse');
    }
}
