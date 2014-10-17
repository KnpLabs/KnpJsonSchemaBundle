<?php
namespace spec\Knp\JsonSchemaBundle\Schema;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SchemaGeneratorSpec extends ObjectBehavior
{
    /**
     * @param JsonSchema\Validator                                      $jsonValidator
     * @param Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator
     * @param Knp\JsonSchemaBundle\Reflection\ReflectionFactory         $reflectionFactory
     * @param Knp\JsonSchemaBundle\Schema\SchemaRegistry                $schemaRegistry
     * @param Knp\JsonSchemaBundle\Model\SchemaFactory                  $schemaFactory
     * @param Knp\JsonSchemaBundle\Model\PropertyFactory                $propertyFactory
     * @param Knp\JsonSchemaBundle\Property\PropertyHandlerInterface    $handler1
     * @param Knp\JsonSchemaBundle\Property\PropertyHandlerInterface    $handler2
     * @param Knp\JsonSchemaBundle\Property\PropertyHandlerInterface    $handler3
     */
    function let(
        $jsonValidator, $urlGenerator, $reflectionFactory, $schemaRegistry,
        $schemaFactory, $propertyFactory, $handler1, $handler2, $handler3
    )
    {
        $this->beConstructedWith($jsonValidator, $urlGenerator, $reflectionFactory, $schemaRegistry, $schemaFactory, $propertyFactory);

        $this->registerPropertyHandler($handler1, 3);
        $this->registerPropertyHandler($handler2, 1);
        $this->registerPropertyHandler($handler3, 2);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Schema   $schema
     * @param Knp\JsonSchemaBundle\Model\Property $property
     * @param \ReflectionClass                    $refClass
     * @param \StdClass                           $refProperty
     */
    function it_should_generate_a_valid_json_schema_with_required_properties(
        $jsonValidator, $urlGenerator, $reflectionFactory, $schemaRegistry, $schemaFactory, $propertyFactory,
        $handler1, $handler2, $handler3, $refClass, $refProperty, $schema, $property
    )
    {
        $jsonValidator->check(Argument::any(), Argument::any())->shouldBeCalled();
        $jsonValidator->isValid()->willReturn(true);
        $schemaRegistry->getNamespace('bar')->willReturn('App\\Foo\\Bar');
        $reflectionFactory->create('App\\Foo\\Bar')->willReturn($refClass);
        $schemaFactory->createSchema('Bar')->willReturn($schema);
        $refProperty->name = 'name';
        $refClass->getProperties()->willReturn(array($refProperty));
        $propertyFactory->createProperty('name')->willReturn($property);
        $urlGenerator->generate('show_json_schema', array('alias' => 'bar'), true)->willReturn('some url');
        $schema->getSchema()->willReturn(\Knp\JsonSchemaBundle\Model\Schema::SCHEMA_V3);
        $schema->jsonSerialize()->shouldBeCalled();

        $handler1->handle('App\\Foo\\Bar', $property)->shouldBeCalled();
        $handler2->handle('App\\Foo\\Bar', $property)->shouldBeCalled();
        $handler3->handle('App\\Foo\\Bar', $property)->shouldBeCalled();

        $schema->addProperty($property)->shouldBeCalled();
        $schema->setId('some url#')->shouldBeCalled();
        $schema->setSchema(\Knp\JsonSchemaBundle\Model\Schema::SCHEMA_V3)->shouldBeCalled();
        $schema->setType(\Knp\JsonSchemaBundle\Model\Schema::TYPE_OBJECT)->shouldBeCalled();

        $this->generate('bar');
    }

    function it_should_be_able_to_register_property_handlers()
    {
        $this->getPropertyHandlers()->shouldHaveCount(3);
    }

    function it_should_be_able_to_register_property_handlers_orderly($handler1, $handler2, $handler3)
    {
        $this->getPropertyHandlers()->shouldBe(array($handler1, $handler3, $handler2));
    }
}
