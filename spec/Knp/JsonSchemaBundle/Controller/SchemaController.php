<?php

namespace spec\Knp\JsonSchemaBundle\Controller;

use PHPSpec2\ObjectBehavior;
use Knp\JsonSchemaBundle\Model\Schema;

class SchemaController extends ObjectBehavior
{
    /**
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param Symfony\Bundle\FrameworkBundle\Routing\Router            $router
     * @param Knp\JsonSchemaBundle\HttpFoundation\JsonResponseFactory  $factory
     * @param Knp\JsonSchemaBundle\Schema\SchemaGenerator              $generator
     * @param Knp\JsonSchemaBundle\Schema\SchemaRegistry               $registry
     */
    function let($container, $router, $factory, $generator, $registry)
    {
        $container->get('json_schema.response.factory')->willReturn($factory);
        $container->get('json_schema.generator')->willReturn($generator);
        $container->get('json_schema.registry')->willReturn($registry);
        $container->get('router')->willReturn($router);

        $this->setContainer($container);
    }

    function its_indexAction_should_display_all_registered_json_schema_urls(
        $router, $registry
    )
    {
        $registry->getAliases()->willReturn(['foo', 'bar']);
        $router->generate('show_json_schema', ['alias' => 'foo'], true)->willReturn('http://www.example.com/schemas/foo.json');
        $router->generate('show_json_schema', ['alias' => 'bar'], true)->willReturn('http://www.example.com/schemas/bar.json');

        $data = [
            'foo_url' => 'http://www.example.com/schemas/foo.json',
            'bar_url' => 'http://www.example.com/schemas/bar.json',
        ];

        $response = $this->indexAction();
        $response->shouldBeAnInstanceOf('Symfony\Component\HttpFoundation\JsonResponse');
        $response->getContent()->shouldBe(json_encode($data));
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Schema             $schema
     * @param Symfony\Component\HttpFoundation\JsonResponse $response
     */
    function its_showAction_should_display_a_json_schema_with_according_content_type(
        $generator, $factory, $schema, $response
    )
    {
        $generator->generate('foo')->willReturn($schema);
        $factory->create($schema, 'json', Schema::SCHEMA_LATEST)->willReturn($response);

        $this->showAction('foo')->shouldReturn($response);
    }
}
