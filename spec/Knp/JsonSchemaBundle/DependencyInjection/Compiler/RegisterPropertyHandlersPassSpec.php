<?php

namespace spec\Knp\JsonSchemaBundle\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;

class RegisterPropertyHandlersPassSpec extends ObjectBehavior
{
    /**
     * @param Knp\JsonSchemaBundle\DependencyInjection\ReferenceFactory $referenceFactory
     */
    function let($referenceFactory)
    {
        $this->beConstructedWith($referenceFactory);
    }

    function it_should_be_a_compiler_pass()
    {
        $this->shouldHaveType('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    /**
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    function it_should_do_nothing_if_schema_generator_is_unavailable(
        $container
    )
    {
        $container->hasDefinition('json_schema.generator')->willReturn(false);

        $container->getDefinition('json_schema.generator')->shouldNotBeCalled();

        $this->process($container);
    }

    /**
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param Symfony\Component\DependencyInjection\Definition       $generatorDef
     * @param Symfony\Component\DependencyInjection\Reference        $handlerRef1
     * @param Symfony\Component\DependencyInjection\Reference        $handlerRef2
     */
    function it_should_register_tagged_propery_handlers(
        $referenceFactory, $container, $generatorDef, $handlerRef1, $handlerRef2
    )
    {
        $container->has('json_schema.generator')->willReturn(true);
        $container->getDefinition('json_schema.generator')->willReturn($generatorDef);
        $container->findTaggedServiceIds('json_schema.property.handler')->willReturn([
            'json_schema.handler_1' => [ 0 => ['priority' => 10]],
            'json_schema.handler_2' => [ 0 => ['priority' => 20]],
        ]);
        $referenceFactory->createReference('json_schema.handler_1')->willReturn($handlerRef1);
        $referenceFactory->createReference('json_schema.handler_2')->willReturn($handlerRef2);

        $generatorDef->addMethodCall('registerPropertyHandler', [$handlerRef1, 10])->shouldBeCalled();
        $generatorDef->addMethodCall('registerPropertyHandler', [$handlerRef2, 20])->shouldBeCalled();

        $this->process($container);
    }

}
