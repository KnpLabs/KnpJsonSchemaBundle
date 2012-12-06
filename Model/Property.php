<?php

namespace Knp\JsonSchemaBundle\Model;

use Symfony\Component\Validator\Constraint;

class Property implements \JsonSerializable
{
    const TYPE_STRING  = 'string';
    const TYPE_NUMBER  = 'number';
    const TYPE_INTEGER = 'integer';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_OBJECT  = 'object';
    const TYPE_ARRAY   = 'array';
    const TYPE_NULL    = 'null';
    const TYPE_ANY     = 'any';

    protected $name;
    protected $required = false;
    protected $type;
    protected $pattern;
    protected $enumeration = array();
    protected $minimum;
    protected $maximum;

    public function setName($name)
    {
        if (!$this->name) {
            $this->name = $name;
        }

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setRequired($required)
    {
        if (!$this->required) {
            $this->required = $required;
        }

        return $this;
    }

    public function isRequired()
    {
        return $this->required;
    }

    public function setType($type)
    {
        if (!$this->type) {
            $this->type = $type;
        }

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setPattern($pattern)
    {
        if (!$this->pattern) {
            $this->pattern = $pattern;
        }

        return $this;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function setEnumeration(array $enumeration)
    {
        if (!$this->enumeration) {
            $this->enumeration = $enumeration;
        }

        return $this;
    }

    public function getEnumeration()
    {
        return $this->enumeration;
    }

    public function setMinimum($minimum)
    {
        if (!$this->minimum) {
            $this->minimum = $minimum;
        }

        return $this;
    }

    public function getMinimum()
    {
        return $this->minimum;
    }

    public function setMaximum($maximum)
    {
        if (!$this->maximum) {
            $this->maximum = $maximum;
        }

        return $this;
    }

    public function getMaximum()
    {
        return $this->maximum;
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

        if (in_array($this->type, [self::TYPE_NUMBER, self::TYPE_INTEGER])) {
            if ($this->minimum) {
                $serialized['minimum'] = $this->minimum;
            }
            if ($this->maximum) {
                $serialized['maximum'] = $this->maximum;
            }
        }

        if (self::TYPE_STRING === $this->type) {
            if ($this->minimum) {
                $serialized['minLength'] = $this->minimum;
            }
            if ($this->maximum) {
                $serialized['maxLength'] = $this->maximum;
            }
        }

        return $serialized;
    }
}
