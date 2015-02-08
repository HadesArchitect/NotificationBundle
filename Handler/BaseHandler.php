<?php

namespace HadesArchitect\NotificationBundle\Handler;

use HadesArchitect\NotificationBundle\Channel\NotificationChannelInterface;
use HadesArchitect\NotificationBundle\Exception\TemplatingException;
use HadesArchitect\NotificationBundle\Notification\Notification;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Templating\EngineInterface;

class BaseHandler implements HandlerInterface
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
    protected $receiver;

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
        if (null === $this->templatingEngine) {
            throw new TemplatingException('Set template engine first');
        }

        if (!$this->templatingEngine->supports($templateName)) {
            throw new TemplatingException(sprintf('Template %s is not supported by templating engine', $templateName));
        }

        $this->templateName = $templateName;
    }

    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }

    public function onEvent(Event $event, $eventName)
    {
        $view = $this->templatingEngine->render(
            $this->templateName, array(
                'event_name' => $eventName,
                'event'      => $event,
                'receiver'   => $this->receiver
            )
        );

        $this->channel->send($this->getNotification($view));
    }

    protected function getNotification($body)
    {
        $notification = new Notification();

        $notification
            ->setReceiver($this->receiver)
            ->setBody($body);

        return $notification;
    }
}
