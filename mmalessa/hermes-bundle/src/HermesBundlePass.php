<?php

declare(strict_types=1);

namespace Mmalessa\Hermes;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HermesBundlePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
//        echo "############ Process HermesBundle\n";
    }
}
