<?php

namespace Bundle\Everzet\JadeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jade');

        // see: http://symfony.com/doc/current/cookbook/bundles/extension.html#validation-and-merging-with-a-configuration-class
    }
}