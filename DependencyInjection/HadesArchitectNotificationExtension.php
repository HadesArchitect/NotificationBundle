<?php

namespace HadesArchitect\NotificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class HadesArchitectNotificationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $containerBuilder)
    {
        $loader = new Loader\YamlFileLoader($containerBuilder, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('parameters.yml');
        $loader->load('services.yml');

        $configuration = $this->getBundleConfiguration($containerBuilder);
        $config = $this->processConfiguration($configuration, $configs);

        $containerBuilder->setAlias('ha_notification.channel', $this->getServiceId($config['default_channel']));

        $containerBuilder
            ->findDefinition('ha_notification.channel.swiftmailer')
            ->addMethodCall('setSender', [$config['swiftmailer_channel']['sender']]);

        if (isset($config['handlers'])) {
            foreach ($config['handlers'] as $name => $handlerConfig) {
                $containerBuilder->setDefinition(
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
        $class = $handlerConfig['handler_class'];

        $definition = new Definition($class);

        $definition->addMethodCall('setTemplatingEngine', array($this->getReference($handlerConfig['templating'])));
        $definition->addMethodCall('setChannel', array($this->getReference($handlerConfig['channel'])));
        $definition->addMethodCall('setTemplateName', array($handlerConfig['template']));
        $definition->addMethodCall('setReceiver', array($handlerConfig['receiver']));
        $definition->addTag('kernel.event_listener', array('event' => $handlerConfig['event'], 'method' => 'onEvent'));

        if ($this->classImplements($class, 'HadesArchitect\NotificationBundle\Handler\TranslatorAwareHandlerInterface')) {
            $definition->addMethodCall('setTranslator', array($this->getReference('@translator')));
        }

        if ($this->isSubjectable($handlerConfig)) {
            $definition->addMethodCall('setSubject', array($handlerConfig['subject']));
        }

        return $definition;
    }

    protected function classImplements($class, $interface)
    {
        return in_array($interface, class_implements($class));
    }

    /**
     * @param $handlerConfig
     *
     * @return bool
     */
    protected function isSubjectable($handlerConfig)
    {
        return
            $this->classImplements($handlerConfig['handler_class'], 'HadesArchitect\NotificationBundle\Handler\SubjectAwareHandlerInterface')
            && array_key_exists('subject', $handlerConfig);
    }

    protected function getBundleConfiguration(ContainerBuilder $containerBuilder)
    {
        return new Configuration(
            $containerBuilder->getParameter('ha_notification.handler.default_class'),
            $containerBuilder->getParameter('ha_notification.view.default_template'),
            $containerBuilder->getParameter('ha_notification.default_subject')
        );
    }

    protected function getReference($id)
    {
        return new Reference($this->getServiceId($id));
    }

    protected function getServiceId($id)
    {
        return ltrim($id, '@');
    }
}
