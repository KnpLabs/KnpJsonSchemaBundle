<?php

namespace Knp\JsonSchemaBundle\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\Reader;
use Knp\JsonSchemaBundle\Schema\SchemaRegistry;
use Knp\JsonSchemaBundle\Schema\ReflectionFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterJsonSchemaCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('json_schema.registry')) {
            return;
        }

        if (null === $reader = $container->get('doctrine.annotations.cached_reader')) {
            return;
        }

        if (null === $registry = $container->get('json_schema.registry')) {
            return;
        }

        if (null === $factory = $container->get('json_schema.reflection_factory')) {
            return;
        }

        $refClasses = $factory->createFromDirectory('');

        foreach ($refClasses as $refClass) {
            foreach ($reader->getClassAnnotations($refClass) as $annotation) {
                if ($annotation instanceof \Knp\JsonSchemaBundle\Annotations\Schema) {
                    $registry->add($annotation->name, $refClass->getName());
                }
            }
        }
    }
}
