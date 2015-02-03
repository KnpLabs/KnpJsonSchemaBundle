<?php

namespace Knp\JsonSchemaBundle\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\Reader;
use Knp\JsonSchemaBundle\Schema\SchemaRegistry;
use Knp\JsonSchemaBundle\Schema\ReflectionFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class RegisterMappingsPass implements CompilerPassInterface
{
    protected $bundle;

    public function process(ContainerBuilder $container)
    {
        if (
            !$container->hasDefinition('json_schema.registry') ||
            !$container->has('annotation_reader') ||
            !$container->has('json_schema.reflection_factory')
        ) {
            return;
        }

        $registry = $container->getDefinition('json_schema.registry');
        $reader   = $container->get('annotation_reader');
        $factory  = $container->get('json_schema.reflection_factory');

        $mappings = $container->getParameter('json_schema.mappings');

        foreach ($mappings as $mapping) {
            if (isset($mapping['dir']) && isset($mapping['prefix'])) {
                /** @var \ReflectionClass[] $refClasses */
                $refClasses = $factory->createFromDirectory(
                    $mapping['dir'],
                    $mapping['prefix']
                );

                foreach ($refClasses as $refClass) {
                    foreach ($reader->getClassAnnotations($refClass) as $annotation) {
                        if ($annotation instanceof \Knp\JsonSchemaBundle\Annotations\Schema) {
                            $alias = $annotation->name ?: strtolower($refClass->getShortName());
                            $registry->addMethodCall('register', [$alias, $refClass->getName()]);
                        }
                    }
                }
            } elseif (isset($mapping['class'])) {
                $refClass = new \ReflectionClass($mapping['class']);
                foreach ($reader->getClassAnnotations($refClass) as $annotation) {
                    if ($annotation instanceof \Knp\JsonSchemaBundle\Annotations\Schema) {
                        $alias = $annotation->name ?: strtolower($refClass->getShortName());
                        $registry->addMethodCall('register', [$alias, $refClass->getName()]);
                    }
                }
            } else {
                throw new \RuntimeException("Invalid mapping configuration!");
            }
        }
    }
}
