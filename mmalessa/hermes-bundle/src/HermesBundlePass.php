<?php

declare(strict_types=1);

namespace Mmalessa\Hermes;

use Mmalessa\Hermes\Receiver\ReceiverFactoryInterface;
use Mmalessa\Hermes\Receiver\ReceiverInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class HermesBundlePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        echo "BUNDLLE PASS -> process\n";

        // Configuration
        if (!$container->hasParameter('hermes.configuration')) {
            return;
        }
        $configuration = $container->getParameter('hermes.configuration');

        // Receiver Factories
        $receiverFactories = [];
        $receiverFactoryServices = $container->findTaggedServiceIds('hermes.receiver_factory');
        foreach (array_keys($receiverFactoryServices) as $receiverFactoryServiceId) {
            if (is_subclass_of($receiverFactoryServiceId, ReceiverFactoryInterface::class)) {
                $type = $receiverFactoryServiceId::type();
                $receiverFactories[$type] = $receiverFactoryServiceId;
            }
        }

        // Receivers
        $configurationReceivers = $configuration['receivers'];
        $receivers = [];
        foreach ($configurationReceivers as $receiverName => $receiverConfig) {
            $type = $receiverConfig['type'];
            $options = $receiverConfig['options'];
            $handlerServiceId = $receiverConfig['handler'];
            if (!$container->hasDefinition($handlerServiceId) && !$container->hasAlias($handlerServiceId)) {
                throw new \LogicException(sprintf('Service "%s" not found for Hermes receiver "%s".', $handlerServiceId, $receiverName));
            }
            $receiverFactoryClassName = $receiverFactories[$type];
            $receiverDefinition = new Definition(ReceiverInterface::class);
            $receiverDefinition->setFactory([new Reference($receiverFactoryClassName), 'create']);
            $receiverDefinition->setArguments([$receiverName, $options]);
            $receiverDefinition->addMethodCall('setHandler', [new Reference($handlerServiceId)]);
            $receiverDefinition->setPublic(true);
            $serviceId = sprintf('hermes.receiver.%s', $receiverName);
            $container->setDefinition($serviceId, $receiverDefinition);
        }
    }
}
