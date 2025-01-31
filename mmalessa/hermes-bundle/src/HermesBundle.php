<?php

declare(strict_types=1);

namespace Mmalessa\Hermes;

use Mmalessa\Hermes\DependencyInjection\HermesBundleExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class HermesBundle extends AbstractBundle
{
    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
//        $builder->registerAttributeForAutoconfiguration(
//
//        );
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new HermesBundleExtension();
        }
        return $this->extension;
    }

    public function build(ContainerBuilder $container): void
    {

//        echo "############# Build\n";

//        echo "############# Load config services.yaml\n";
//        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/Resources/config'));
//        $loader->load('services.yaml');
//        echo "############# Add compiler pass\n";
        $container->addCompilerPass(new HermesBundlePass());
    }
}
