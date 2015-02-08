<?php

namespace HadesArchitect\NotificationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ha_notification');

        $rootNode
            ->children()
                ->scalarNode('default_channel')->cannotBeEmpty()->isRequired()->end()
                ->arrayNode('handlers')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('event')->isRequired()->end()
                            ->scalarNode('template')->defaultValue('%ha_notification.view.default_template%')->end()
                            ->scalarNode('templating')->defaultValue('@templating')->end()
                            ->scalarNode('handler_class')->defaultValue('%ha_notification.handler.default_class%')->end()
                            ->scalarNode('channel')->defaultValue('@ha_notification.channel')->end()
                            ->variableNode('receiver')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
