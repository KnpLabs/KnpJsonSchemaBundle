<?php

namespace Knp\JsonSchemaBundle\Annotations;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Object
{
    /** @var string */
    public $alias;

    /** @var bool */
    public $multiple = false;
}
