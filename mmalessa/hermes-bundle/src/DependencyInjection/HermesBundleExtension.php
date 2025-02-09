<?php

declare(strict_types=1);

namespace Mmalessa\Hermes\DependencyInjection;

use Mmalessa\Hermes\Receiver\ReceiverFactoryInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class HermesBundleExtension extends Extension
{
    public function getAlias(): string
    {
        return 'hermes';
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        echo "HermesBundleExtension:load()\n";
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

//        $container->registerForAutoconfiguration(ReceiverFactoryInterface::class)
//            ->addTag('hermes.receiver_factory');

        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->processConfiguration($configuration, $configs);
        $container->setParameter('hermes.configuration', $config);
    }

}
