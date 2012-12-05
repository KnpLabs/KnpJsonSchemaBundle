<?php

namespace Knp\JsonSchemaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterConstraintHandlerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('json_schema.builder')) {
            return;
        }

        $definition = $container->getDefinition(
            'json_schema.builder'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'json_schema.builder.handler'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'registerConstraintHandler',
                array(new Reference($id), $this->getPriority($attributes))
            );
        }
    }

    private function getPriority(array $attributes = array())
    {
        if (isset($attributes['priority'])) {
            return $attributes['priority'];
        }

        return 0;
    }
}
