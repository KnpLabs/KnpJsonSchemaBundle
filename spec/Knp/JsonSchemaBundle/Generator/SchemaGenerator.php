<?php

namespace spec\Knp\JsonSchemaBundle\Generator;

use PHPSpec2\ObjectBehavior;

class SchemaGenerator extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Validator\Mapping\ClassMetadataFactoryInterface $classMetadataFactory
     */
    function let($classMetadataFactory)
    {
        $this->beConstructedWith($classMetadataFactory);
    }

    /**
     * @param stdClass $entity
     * @param Symfony\Component\Validator\Mapping\ClassMetadata $classMetadata
     * @param Symfony\Component\Validator\Mapping\PropertyMetadata $propertyMetadata
     * @param Symfony\Component\Validator\Constraints\NotBlank $constraint
     * @param \ReflectionClass $refClass
     */
    function it_should_generate_a_valid_json_schema_with_required_properties($classMetadataFactory, $classMetadata, $propertyMetadata, $constraint, $refClass, $entity)
    {
        $classMetadataFactory->getClassMetadata('App\\Entity\\User')->willReturn($classMetadata);
        $classMetadata->getReflectionClass()->willReturn($refClass);
        $classMetadata->properties = [$propertyMetadata];
        $propertyMetadata->constraints = [$constraint];
        $refClass->getShortName()->willReturn('User');

        $this->generate('App\\Entity\\User');
}
