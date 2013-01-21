<?php

namespace Knp\JsonSchemaBundle\Model;

class Schema implements \JsonSerializable
{
    const TYPE_OBJECT = 'object';
    const SCHEMA_V3 = 'http://json-schema.org/draft-04/schema#';

    private $title;
    private $id;
    private $type;
    private $schema;
    private $properties;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function addProperty(Property $property)
    {
        $this->properties[$property->getName()] = $property;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getSchema()
    {
        return $this->schema;
    }

    public function setSchema($schema)
    {
        $this->schema = $schema;
    }

    public function jsonSerialize()
    {
        return [
            'title'      => $this->title,
            'type'       => $this->type,
            '$schema'    => $this->schema,
            'id'         => $this->id,
            'properties' => $this->properties,
        ];
    }
}
