<?php

namespace Knp\JsonSchemaBundle\Schema;

class ReflectionFactory
{
    public function create($className)
    {
        return new \ReflectionClass($className);
    }
}

