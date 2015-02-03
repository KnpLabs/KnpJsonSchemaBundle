<?php

namespace Knp\JsonSchemaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class KnpJsonSchemaExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $guesserService = $config['db_driver'] === 'orm' ? 'form.type_guesser.doctrine' : 'form.type_guesser.doctrine.mongodb';
        $container->setAlias('json_schema.guesser', $guesserService, false);
        $container->setParameter('json_schema.mappings', $config['mappings']);
    }
}
