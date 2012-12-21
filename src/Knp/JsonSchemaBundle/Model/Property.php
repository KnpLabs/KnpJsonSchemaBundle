<?php

namespace Knp\JsonSchemaBundle\Model;

use Symfony\Component\Validator\Constraint;

class Property implements \JsonSerializable
{
    const TYPE_STRING        = 'string';
    const TYPE_NUMBER        = 'number';
    const TYPE_INTEGER       = 'integer';
    const TYPE_BOOLEAN       = 'boolean';
    const TYPE_OBJECT        = 'object';
    const TYPE_ARRAY         = 'array';
    const TYPE_NULL          = 'null';
    const TYPE_ANY           = 'any';
    const FORMAT_DATETIME    = 'date-time';
    const FORMAT_DATE        = 'date';
    const FORMAT_TIME        = 'time';
    const FORMAT_UTCMILLISEC = 'utc-millisec';
    const FORMAT_REGEX       = 'regex';
    const FORMAT_COLOR       = 'color';
    const FORMAT_STYLE       = 'style';
    const FORMAT_PHONE       = 'phone';
    const FORMAT_URI         = 'uri';
    const FORMAT_EMAIL       = 'email';
    const FORMAT_IPADDRESS   = 'ip-address';
    const FORMAT_IPV6        = 'ipv6';
    const FORMAT_HOSTNAME    = 'host-name';

    protected $name;
    protected $required = false;
    protected $types = [];
    protected $pattern;
    protected $enumeration = [];
    protected $minimum;
    protected $maximum;
    protected $exclusiveMinimum = false;
    protected $exclusiveMaximum = false;
    protected $format;
    protected $disallowed = [];

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

    public function addType($type)
    {
        if (!in_array($type, $this->types)) {
            $this->types[] = $type;
        }

        return $this;
    }

    public function getTypes()
    {
        return $this->types;
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

    public function setExclusiveMinimum($exclusiveMinimum)
    {
        if (!$this->exclusiveMinimum) {
            $this->exclusiveMinimum = $exclusiveMinimum;
        }

        return $this;
    }

    public function isExclusiveMinimum()
    {
        return $this->exclusiveMinimum;
    }

    public function setExclusiveMaximum($exclusiveMaximum)
    {
        if (!$this->exclusiveMaximum) {
            $this->exclusiveMaximum = $exclusiveMaximum;
        }

        return $this;
    }

    public function isExclusiveMaximum()
    {
        return $this->exclusiveMaximum;
    }

    public function setFormat($format)
    {
        if (!$this->format) {
            $this->format = $format;
        }

        return $this;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setDisallowed(array $disallowed)
    {
        if (!$this->disallowed) {
            $this->disallowed = $disallowed;
        }

        return $this;
    }

    public function getDisallowed()
    {
        return $this->disallowed;
    }

    public function jsonSerialize()
    {
        $serialized['required'] =  $this->required;

        if (count($this->types)) {
            if (count($this->types) === 1) {
                $serialized['type'] = $this->types[0];
            } else {
                $serialized['type'] = $this->types;
            }
        }

        if ($this->pattern) {
            $serialized['pattern'] = $this->pattern;
        }

        if (count($this->enumeration)) {
            $serialized['enum'] = $this->enumeration;
        }

        if (count(array_intersect($this->types, [self::TYPE_NUMBER, self::TYPE_INTEGER])) >= 1) {
            if ($this->minimum) {
                $serialized['minimum']          = $this->minimum;
                $serialized['exclusiveMinimum'] = $this->exclusiveMinimum;
            }
            if ($this->maximum) {
                $serialized['maximum']          = $this->maximum;
                $serialized['exclusiveMaximum'] = $this->exclusiveMaximum;
            }
        }

        if (count(array_intersect($this->types, [self::TYPE_STRING])) >= 1) {
            if ($this->minimum) {
                $serialized['minLength'] = $this->minimum;
            }
            if ($this->maximum) {
                $serialized['maxLength'] = $this->maximum;
            }
        }

        if ($this->format) {
            $serialized['format'] = $this->format;
        }

        if ($this->disallowed) {
            $serialized['disallow'] = $this->disallowed;
        }

        return $serialized;
    }
}
