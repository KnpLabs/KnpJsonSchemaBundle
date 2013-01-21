<?php

namespace Knp\JsonSchemaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Reference;

class ReferenceFactory
{
    public function createReference($id)
    {
        return new Reference($id);
    }
}
