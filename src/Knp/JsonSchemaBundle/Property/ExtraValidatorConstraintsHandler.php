<?php

namespace Knp\JsonSchemaBundle\Property;

use Knp\JsonSchemaBundle\Model\Property;
use Symfony\Component\Validator\MetadataFactoryInterface;

class ExtraValidatorConstraintsHandler implements PropertyHandlerInterface
{
    private $classMetadataFactory;

    public function __construct(MetadataFactoryInterface $classMetadataFactory)
    {
        $this->classMetadataFactory = $classMetadataFactory;
    }

    public function handle($className, Property $property)
    {
        foreach ($this->getConstraintsForProperty($className, $property) as $constraint) {
            if ($constraint instanceof \Symfony\Component\Validator\Constraints\Choice) {
                $property->setEnumeration($constraint->choices);
            }
            if ($constraint instanceof \Symfony\Component\Validator\Constraints\Length) {
                $property->setMinimum($constraint->min);
                $property->setMaximum($constraint->max);
            }
            if ($constraint instanceof \Symfony\Component\Validator\Constraints\Type) {
                $property->addType($constraint->type);
            }
            if ($constraint instanceof \Symfony\Component\Validator\Constraints\Date) {
                $property->setFormat(Property::FORMAT_DATE);
            }
            if ($constraint instanceof \Symfony\Component\Validator\Constraints\DateTime) {
                $property->setFormat(Property::FORMAT_DATETIME);
            }
            if ($constraint instanceof \Symfony\Component\Validator\Constraints\Time) {
                $property->setFormat(Property::FORMAT_TIME);
            }
            if ($constraint instanceof \Symfony\Component\Validator\Constraints\Email) {
                $property->setFormat(Property::FORMAT_EMAIL);
            }
            if ($constraint instanceof \Symfony\Component\Validator\Constraints\Ip) {
                if ('4' === $constraint->version) {
                    $property->setFormat(Property::FORMAT_IPADDRESS);
                } elseif ('6' === $constraint->version) {
                    $property->setFormat(Property::FORMAT_IPV6);
                }
            }
        }
    }

    private function getConstraintsForProperty($className, Property $property)
    {
        $classMetadata = $this->classMetadataFactory->getMetadataFor($className);

        foreach ($classMetadata->properties as $propertyMetadata) {
            if ($propertyMetadata->name === $property->getName()) {
                return $propertyMetadata->constraints;
            }
        }

        return array();
    }
}
