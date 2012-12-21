<?php

namespace Knp\JsonSchemaBundle\Annotations;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Type
{
    /** @var array */
    public $types = [];
}
