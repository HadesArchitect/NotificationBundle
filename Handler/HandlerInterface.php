<?php

namespace HadesArchitect\NotificationBundle\Handler;

use HadesArchitect\NotificationBundle\Channel\NotificationChannelInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Templating\EngineInterface;

interface HandlerInterface
{
    function setTemplateName($templateName);

    function setTemplatingEngine(EngineInterface $engine);

    function setChannel(NotificationChannelInterface $channel);

    function setReceiver(array $receiver);

    function onEvent(Event $event);
}
