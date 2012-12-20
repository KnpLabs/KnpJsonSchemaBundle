<?php

namespace Knp\JsonSchemaBundle\Annotations;

/**
 * @Annotation
 * @Target({"Property"})
 */
class Type
{
    /** @var array */
    public $types = [];
}
