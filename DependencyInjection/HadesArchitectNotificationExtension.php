<?php

namespace HadesArchitect\NotificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class HadesArchitectNotificationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('parameters.yml');
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setAlias('ha_notification.channel', $config['default_channel']);

        if (isset($config['handlers'])) {
            foreach ($config['handlers'] as $name => $handlerConfig) {
                $container->setDefinition(
                    $this->getHandlerName($name),
                    $this->getHandlerDefinition($handlerConfig)
                );
            }
        }
    }

    public function getAlias()
    {
        return 'ha_notification';
    }

    protected function getHandlerName($name)
    {
        return sprintf('ha_notification.handler.%s', $name);
    }

    protected function getHandlerDefinition($handlerConfig)
    {
        $definition = new Definition($handlerConfig['handler_class']);

        $definition->addMethodCall('setTemplatingEngine', array($this->getReference($handlerConfig['templating'])));
        $definition->addMethodCall('setChannel', array($this->getReference($handlerConfig['channel'])));
        $definition->addMethodCall('setTemplateName', array($handlerConfig['template']));
        $definition->addMethodCall('setReceiver', array($handlerConfig['receiver']));
        $definition->addTag('kernel.event_listener', array('event' => $handlerConfig['event'], 'method' => 'onEvent'));

        return $definition;
    }

    protected function getReference($id)
    {
        return new Reference(ltrim($id, '@'));
    }
}
