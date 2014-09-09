<?php

namespace Knp\JsonSchemaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Knp\JsonSchemaBundle\DependencyInjection\ReferenceFactory;

class RegisterPropertyHandlersPass implements CompilerPassInterface
{
    public function __construct(ReferenceFactory $referenceFactory = null)
    {
        $this->referenceFactory = $referenceFactory ?: new ReferenceFactory();
    }

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('json_schema.generator')) {
            return;
        }

        $definition = $container->getDefinition(
            'json_schema.generator'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'json_schema.property.handler'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'registerPropertyHandler',
                array($this->referenceFactory->createReference($id), $this->getPriority($attributes))
            );
        }
    }

    private function getPriority(array $attributes = array())
    {
        if (isset($attributes[0]['priority'])) {
            return $attributes[0]['priority'];
        }

        return 0;
    }
}
