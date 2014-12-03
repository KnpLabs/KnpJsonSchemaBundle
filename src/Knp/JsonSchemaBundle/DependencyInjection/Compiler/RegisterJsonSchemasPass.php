<?php

namespace Knp\JsonSchemaBundle\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\Reader;
use Knp\JsonSchemaBundle\Schema\SchemaRegistry;
use Knp\JsonSchemaBundle\Schema\ReflectionFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class RegisterJsonSchemasPass implements CompilerPassInterface
{
    protected $bundle, $directory;

    public function __construct(BundleInterface $bundle, $directory = 'Entity')
    {
        $this->bundle = $bundle;
        $this->directory = $directory;
    }

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

        $refClasses = $factory->createFromDirectory(
            $this->bundle->getPath().'/'.$this->directory,
            $this->bundle->getNamespace().'\\'.$this->directory
        );

        foreach ($refClasses as $refClass) {
            foreach ($reader->getClassAnnotations($refClass) as $annotation) {
                if ($annotation instanceof \Knp\JsonSchemaBundle\Annotations\Schema) {
                    $alias = $annotation->name ?: strtolower($refClass->getShortName());
                    $registry->addMethodCall('register', array($alias, $refClass->getName()));
                }
            }
        }
    }
}
