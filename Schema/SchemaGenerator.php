<?php

namespace Knp\JsonSchemaBundle\Schema;

use Knp\JsonSchemaBundle\Model\Schema;
use Knp\JsonSchemaBundle\Model\Property;

class SchemaGenerator
{
    private $classMetadataFactory;
    private $jsonValidator;
    private $reflectionFactory;

    public function __construct(\JsonSchema\Validator $jsonValidator, SchemaBuilder $schemaBuilder, ReflectionFactory $reflectionFactory)
    {
        $this->jsonValidator        = $jsonValidator;
        $this->schemaBuilder        = $schemaBuilder;
        $this->reflectionFactory    = $reflectionFactory;
    }

    public function generate($className)
    {
        $refl = $this->reflectionFactory->create($className);
        $this->schemaBuilder->setName(strtolower($refl->getShortName()));

        foreach ($refl->getProperties() as $property) {
            $this->schemaBuilder->addProperty($className, $property);
        }

        if (false === $this->validateSchema($schema = $this->schemaBuilder->getSchema())) {
            $message = "Generated schema is invalid. The following problem(s) were detected:\n";
            foreach ($this->jsonValidator->getErrors() as $error) {
                $message .= sprintf("[%s] %s\n", $error['property'], $error['message']);
            }
            $message .= sprintf("Json schema:\n%s", json_encode($schema, JSON_PRETTY_PRINT));
            throw new \Exception($message);
        }

        return $schema;
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
