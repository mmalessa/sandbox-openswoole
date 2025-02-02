<?php

declare(strict_types=1);

namespace Mmalessa\Hermes;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HermesBundlePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
//        if (!$container->hasDefinition('hermes.receivers')) {
//            echo "Hermes receivers not found\n";
//        }
//        $receivers = $container->getDefinition('hermes.receivers');
//
//        if (!$container->hasParameter('hermes.configuration')) {
//            echo "Hermes configuration not found\n";
//        }
//        $configuration = $container->getParameter('hermes.configuration');
//        echo "############ Process HermesBundle\n";
//        $receiverFactory = new ReceiverFactory(); // FIXME
//        foreach ($configuration['receivers'] as $receiverName => $receiverConfiguration) {
//            $options = Options::createFromArray($receiverConfiguration['options']);
//            $receiver = $receiverFactory->create($receiverConfiguration['type'], $options);
//            $receivers->addMethodCall('register', [$receiverName, $receiver]);
//        }


    }
}
