<?php

namespace Knp\JsonSchemaBundle\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\Reader;
use Knp\JsonSchemaBundle\Schema\SchemaRegistry;
use Knp\JsonSchemaBundle\Schema\ReflectionFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class RegisterJsonSchemaCompilerPass implements CompilerPassInterface
{
    protected $bundle;

    public function __construct(BundleInterface $bundle)
    {
        $this->bundle = $bundle;
    }

    public function process(ContainerBuilder $container)
    {
        if (!$container->has('json_schema.registry')) {
            return;
        }

        if (null === $registry = $container->getDefinition('json_schema.registry')) {
            return;
        }

        if (null === $reader = $container->get('doctrine.annotations.cached_reader')) {
            return;
        }

        if (null === $factory = $container->get('json_schema.reflection_factory')) {
            return;
        }

        $refClasses = $factory->createFromDirectory(
            $this->bundle->getPath().'/Entity',
            $this->bundle->getNamespace().'\Entity'
        );

        foreach ($refClasses as $refClass) {
            foreach ($reader->getClassAnnotations($refClass) as $annotation) {
                if ($annotation instanceof \Knp\JsonSchemaBundle\Annotations\Schema) {
                    $registry->addMethodCall('register', [$annotation->name, $refClass->getName()]);
                }
            }
        }
    }
}
