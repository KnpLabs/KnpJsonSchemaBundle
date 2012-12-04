<?php

namespace Knp\JsonSchemaBundle\Model;

use Symfony\Component\Validator\Constraint;

class Property implements \JsonSerializable
{
    protected $name;
    protected $required = false;
    protected $type;
    protected $pattern;
    protected $enumeration = array();

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

    public function setEnumeration(array $enumeration)
    {
        $this->enumeration = $enumeration;

        return $this;
    }

    public function getEnumeration()
    {
        return $this->enumeration;
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

        if (count($this->enumeration)) {
            $serialized['enum'] = $this->enumeration;
        }

        return $serialized;
    }

    public function addConstraint(Constraint $constraint)
    {
        if (is_a($constraint, 'Symfony\Component\Validator\Constraints\NotBlank')) {
            $this->setRequired(true);
        }

        else if (is_a($constraint, 'Symfony\Component\Validator\Constraints\Blank')) {
            $this->setPattern('/^$/');
        }

        else if (is_a($constraint, 'Symfony\Component\Validator\Constraints\Type')) {
            $this->setType($constraint->type);
        }

        else if (is_a($constraint, 'Symfony\Component\Validator\Constraints\Regex')) {
            $this->setPattern($constraint->pattern);
        }

        else if (is_a($constraint, 'Symfony\Component\Validator\Constraints\Choice')) {
            $this->setEnumeration($constraint->choices);
        }
    }
}
