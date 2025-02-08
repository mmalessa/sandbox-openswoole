<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('hermes');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
            ->arrayNode('receivers')
            ->info('List of receivers')
            ->useAttributeAsKey('name')
            ->arrayPrototype()
                ->children()
                    ->scalarNode('type')->isRequired()->cannotBeEmpty()->end()
                    ->scalarNode('handler')->isRequired()->cannotBeEmpty()->end()
                    ->arrayNode('options')
                        ->children()
                            ->scalarNode('host')->end()
                            ->scalarNode('port')->end()
                            ->scalarNode('mode')->end()
                            ->arrayNode('settings')
                                ->normalizeKeys(false)->variablePrototype()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
