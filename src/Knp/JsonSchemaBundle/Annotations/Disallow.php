<?php

namespace Knp\JsonSchemaBundle\Annotations;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Disallow
{
    /** @var array */
    public $disallowed = array();
}
