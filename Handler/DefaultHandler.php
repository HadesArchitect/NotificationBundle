<?php

namespace HadesArchitect\NotificationBundle\Handler;

use Symfony\Component\EventDispatcher\Event;

class DefaultHandler extends BaseHandler
{
    public function onEvent(Event $event)
    {
        $view = $this->templatingEngine->render($this->templateName, array('event' => $event));

        $this->channel->send($this->receiver, $view);
    }
}
