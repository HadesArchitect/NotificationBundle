<?php

/*
 * This file is part of the HadesArchitect Notification bundle
 *
 * (c) Aleksandr Volochnev <a.volochnev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HadesArchitect\NotificationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    protected $handlerClass;
    protected $template;
    protected $subject;

    public function __construct($handlerClass, $template, $subject)
    {
        $this->handlerClass = $handlerClass;
        $this->template     = $template;
        $this->subject      = $subject;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ha_notification');

        $rootNode
            ->children()
                ->scalarNode('default_channel')
                    ->defaultValue('@ha_notification.channel.swiftmailer')
                ->end()
                ->arrayNode('swiftmailer_channel')
                    ->isRequired()
                    ->children()
                        ->scalarNode('sender')
                            ->cannotBeEmpty()
                            ->isRequired()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('handlers')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('event')->isRequired()->end()
                            ->scalarNode('template')->defaultValue($this->template)->end()
                            ->scalarNode('templating')->defaultValue('@templating')->end()
                            ->scalarNode('subject')->defaultValue($this->subject)->end()
                            ->scalarNode('handler_class')->defaultValue($this->handlerClass)->end()
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
