<?php

namespace Knp\JsonSchemaBundle\Annotations;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class Schema
{
    /** @var string */
    public $name;
}
