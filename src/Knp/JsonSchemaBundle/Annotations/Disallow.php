<?php

namespace Knp\JsonSchemaBundle\Annotations;

/**
 * @Annotation
 * @Target({"Property"})
 */
class Disallow
{
    /** @var array */
    public $disallowed = [];
}
