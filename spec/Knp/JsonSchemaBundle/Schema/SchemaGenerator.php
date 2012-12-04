<?php

namespace spec\Knp\JsonSchemaBundle\Schema;

use PHPSpec2\ObjectBehavior;

class SchemaGenerator extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Validator\Mapping\ClassMetadataFactoryInterface $classMetadataFactory
     * @param JsonSchema\Validator $jsonValidator
     * @param Knp\JsonSchemaBundle\Schema\SchemaBuilder $schemaBuilder
     */
    function let($classMetadataFactory, $jsonValidator, $schemaBuilder)
    {
        $this->beConstructedWith($classMetadataFactory, $jsonValidator, $schemaBuilder);
    }

    /**
     * @param Knp\JsonSchemaBundle\Model\Schema $schema
     * @param Symfony\Component\Validator\Mapping\ClassMetadata $classMetadata
     * @param Symfony\Component\Validator\Mapping\PropertyMetadata $propertyMetadata
     * @param Symfony\Component\Validator\Constraints\NotBlank $constraint
     * @param \ReflectionClass $refClass
     */
    function it_should_generate_a_valid_json_schema_with_required_properties($classMetadataFactory, $jsonValidator, $schemaBuilder, $schema, $classMetadata, $propertyMetadata, $constraint, $refClass)
    {
        $jsonValidator->isValid()->willReturn(true);
        $schemaBuilder->getSchema()->willReturn($schema);

        $classMetadataFactory->getClassMetadata('App\\Entity\\User')->willReturn($classMetadata);
        $classMetadata->getReflectionClass()->willReturn($refClass);
        $classMetadata->properties = [$propertyMetadata];
        $propertyMetadata->constraints = [$constraint];
        $refClass->getShortName()->willReturn('User');

        $this->generate('App\\Entity\\User')->shouldBe($schema);
    }
}
