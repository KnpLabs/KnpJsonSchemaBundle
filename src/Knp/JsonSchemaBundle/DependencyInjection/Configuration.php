<?php

namespace Knp\JsonSchemaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
     protected $supportedDbDrivers = array('orm', 'mongodb');

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder
            ->root('json_schema')
            ->children()
                ->scalarNode('db_driver')
                    ->defaultValue('orm')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return strtolower($v); })
                    ->end()
                    ->validate()
                        ->ifNotInArray($this->supportedDbDrivers)
                        ->thenInvalid('The db driver %s is not supported. Please choose one of ' . implode(', ', $this->supportedDbDrivers))
                    ->end()
                ->end()
                ->arrayNode('mappings')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('dir')->end()
                            ->scalarNode('prefix')->end()
                            ->scalarNode('class')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
