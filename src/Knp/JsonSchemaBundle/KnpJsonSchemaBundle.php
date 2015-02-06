<?php

namespace Knp\JsonSchemaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Knp\JsonSchemaBundle\DependencyInjection\Compiler;

class KnpJsonSchemaBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        // This exists for PHP 5.3 compatibility
        if (!interface_exists('\JsonSerializable')) {
            class_alias('Knp\JsonSchemaBundle\Model\JsonSerializable', 'JsonSerializable');
        }

        $container->addCompilerPass(new Compiler\RegisterPropertyHandlersPass());
        $container->addCompilerPass(new Compiler\RegisterMappingsPass());
    }
}
