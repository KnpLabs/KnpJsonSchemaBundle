<?php

namespace Knp\JsonSchemaBundle\Generator;

use Symfony\Component\Validator\Mapping\ClassMetadataFactoryInterface;
use Symfony\Component\Validator\Mapping\PropertyMetadata;
use Knp\JsonSchemaBundle\Model\Schema;
use Knp\JsonSchemaBundle\Model\Property;

class SchemaGenerator
{
    private $classMetadataFactory;
    private $jsonValidator;

    public function __construct(ClassMetadataFactoryInterface $classMetadataFactory, \JsonSchema\Validator $jsonValidator)
    {
        $this->classMetadataFactory = $classMetadataFactory;
        $this->jsonValidator        = $jsonValidator;
    }

    public function generate($className)
    {
        $classMetadata = $this->getClassMetadata($className);

        $schema = new Schema();
        $schema->setName(strtolower($classMetadata->getReflectionClass()->getShortName()));

        foreach ($classMetadata->properties as $property) {
            $schema->addProperty($this->createProperty($property));
        }

        if (false === $this->validateSchema($schema)) {
            $message = "Generated schema is invalid. The following problem(s) were detected:\n";
            foreach ($this->jsonValidator->getErrors() as $error) {
                $message .= sprintf("[%s] %s\n", $error['property'], $error['message']);
            }
            throw new \Exception($message);
        }

        return $schema;
    }

    private function createProperty(PropertyMetadata $propertyMetadata)
    {
        $property = new Property();
        $property->setName($propertyMetadata->name);

        foreach ($propertyMetadata->constraints as $constraint) {
            $property->addConstraint($constraint);
        }

        return $property;
    }

    private function getClassMetadata($className)
    {
        return $this->classMetadataFactory->getClassMetadata($className);
    }

    /**
     * Validate a schema against the meta-schema provided by http://json-schema.org/schema
     *
     * @param Schema $schema a json schema
     *
     * @return boolean
     */
    private function validateSchema(Schema $schema)
    {
        $this->jsonValidator->check(
            json_decode(json_encode($schema)),
            json_decode(file_get_contents(__DIR__.'/../Resources/config/schema'))
        );

        return $this->jsonValidator->isValid();
    }
}
