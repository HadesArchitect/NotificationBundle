<?php

namespace HadesArchitect\NotificationBundle\Handler;

use HadesArchitect\NotificationBundle\Channel\NotificationChannelInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Templating\EngineInterface;

abstract class BaseHandler implements HandlerInterface
{
    /**
     * @var EngineInterface
     */
    protected $templatingEngine;

    /**
     * @var string
     */
    protected $templateName;

    /**
     * @var NotificationChannelInterface
     */
    protected $channel;

    /**
     * @var array
     */
    protected $receiver = array();

    function setTemplatingEngine(EngineInterface $engine)
    {
        $this->templatingEngine = $engine;
    }

    function setChannel(NotificationChannelInterface $channel)
    {
        $this->channel = $channel;
    }

    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;
    }

    public function setReceiver(array $receiver)
    {
        $this->receiver = $receiver;
    }

    abstract public function onEvent(Event $event);
}
