<?php

namespace Knp\JsonSchemaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Knp\JsonSchemaBundle\DependencyInjection\Compiler\RegisterConstraintHandlerCompilerPass;

class KnpJsonSchemaBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterConstraintHandlerCompilerPass());
    }
}
