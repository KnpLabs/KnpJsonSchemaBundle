<?php

namespace Knp\JsonSchemaBundle\Annotations;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Ignore
{
    /** @var boolean */
    public $ignored = true;
}
