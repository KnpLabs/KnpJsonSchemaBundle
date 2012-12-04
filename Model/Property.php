<?php

namespace Knp\JsonSchemaBundle\Model;

use Symfony\Component\Validator\Constraint;

class Property implements \JsonSerializable
{
    protected $name;
    protected $required = false;
    protected $type;
    protected $pattern;

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    public function isRequired()
    {
        return $this->required;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function jsonSerialize()
    {
        $serialized['required'] =  $this->required;

        if ($this->type) {
            $serialized['type'] = $this->type;
        }

        if ($this->pattern) {
            $serialized['pattern'] = $this->pattern;
        }

        return $serialized;
    }

    public function addConstraint(Constraint $constraint)
    {
        if (is_a($constraint, 'Symfony\Component\Validator\Constraints\NotBlank')) {
            $this->setRequired(true);
        }

        if (is_a($constraint, 'Symfony\Component\Validator\Constraints\Type')) {
            $this->setType($constraint->type);
        }

        if (is_a($constraint, 'Symfony\Component\Validator\Constraints\Regex')) {
            $this->setPattern($constraint->pattern);
        }
    }
}
