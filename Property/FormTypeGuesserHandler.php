<?php

namespace Knp\JsonSchemaBundle\Property;

use Knp\JsonSchemaBundle\Model\Property;
use Symfony\Component\Form\Guess\TypeGuess;
use Symfony\Component\Form\FormTypeGuesserInterface;

class FormTypeGuesserHandler implements PropertyHandlerInterface
{
    private $guesser;

    public function __construct(FormTypeGuesserInterface $guesser)
    {
        $this->guesser = $guesser;
    }

    public function handle($className, Property $property)
    {
        if ($type = $this->guesser->guessType($className, $property->getName())) {
            $property->setType($this->getPropertyType($type));
        }

        if ($required = $this->guesser->guessRequired($className, $property->getName())) {
            $property->setRequired($required->getValue());
        }

        if ($pattern = $this->guesser->guessPattern($className, $property->getName())) {
            $property->setPattern($pattern->getValue());
        }

        if ($minimum = $this->guesser->guessMinLength($className, $property->getName())) {
            $property->setMinimum($minimum->getValue());
        }

        if ($maximum = $this->guesser->guessMaxLength($className, $property->getName())) {
            $property->setMaximum($maximum->getValue());
        }
    }

    private function getPropertyType(TypeGuess $type)
    {
        switch ($type->getType()) {
            case 'entity':
                return Property::TYPE_OBJECT;
            case 'collection':
                return Property::TYPE_ARRAY;
            case 'checkbox':
                return Property::TYPE_BOOLEAN;
            case 'number':
                return Property::TYPE_NUMBER;
            case 'integer':
                return Property::TYPE_INTEGER;
            case 'date':
            case 'datetime':
            case 'text':
            case 'country':
            case 'email':
            case 'file':
            case 'language':
            case 'locale':
            case 'time':
            case 'url':
                return Property::TYPE_STRING;
        }
    }
}
