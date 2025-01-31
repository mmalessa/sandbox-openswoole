<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class HermesBundleExtension extends Extension
{
    public function getAlias(): string
    {
        return 'hermes';
    }

    public function load(array $configs, ContainerBuilder $container)
    {
//        echo "############# HermesBundleExtension::load\n";
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->processConfiguration($configuration, $configs);
        $container->setParameter('hermes.configuration', $config);

//        $container->setParameter('hermes.api_url', $config['api_url']);
//        $container->setParameter('hermes.api_key', $config['api_key']);
//        $container->setParameter('hermes.features.enable_notifications', $config['features']['enable_notifications']);
//        $container->setParameter('hermes.features.log_requests', $config['features']['log_requests']);
    }
}
