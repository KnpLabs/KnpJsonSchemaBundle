<?php

namespace Knp\JsonSchemaBundle\Constraints;

use Symfony\Component\Validator\Constraint;
use Knp\JsonSchemaBundle\Model\Property;

class ValidatorTypeGuesserHandler implements ConstraintHandlerInterface
{
    private $guesser;

    public function __construct(ValidatorTypeGuesser $guesser)
    {
        $this->guesser = $guesser;
    }

    public function supports($className, Property $property)
    {
        return true;
    }

    public function handle($className, Property $property)
    {
        $type = $this->guesser->guessType($className, $property->getName());
        if ($type) {
            $property->setType($type);
        }
    }
}
