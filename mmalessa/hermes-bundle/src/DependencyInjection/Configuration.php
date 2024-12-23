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
//        $rootNode = $treeBuilder->getRootNode();
//        $rootNode
//            ->children()
//            ->scalarNode('api_url')
//            ->isRequired()
//            ->info('URL do API Hermes.')
//            ->end()
//            ->scalarNode('api_key')
//            ->defaultNull()
//            ->info('Klucz API do autoryzacji.')
//            ->end()
//            ->arrayNode('features')
//            ->addDefaultsIfNotSet()
//            ->children()
//            ->booleanNode('enable_notifications')
//            ->defaultTrue()
//            ->info('Czy włączyć powiadomienia.')
//            ->end()
//            ->booleanNode('log_requests')
//            ->defaultFalse()
//            ->info('Czy logować wszystkie żądania do API.')
//            ->end()
//            ->end()
//            ->end()
//            ->end();
        return $treeBuilder;
    }
}
