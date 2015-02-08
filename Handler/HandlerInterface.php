<?php

/*
 * This file is part of the HadesArchitect Notification bundle
 *
 * (c) Aleksandr Volochnev <a.volochnev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HadesArchitect\NotificationBundle\Handler;

use HadesArchitect\NotificationBundle\Channel\NotificationChannelInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Templating\EngineInterface;

interface HandlerInterface
{
    /**
     * @param string $templateName
     */
    function setTemplateName($templateName);

    /**
     * @param EngineInterface $engine
     */
    function setTemplatingEngine(EngineInterface $engine);

    /**
     * @param NotificationChannelInterface $channel
     */
    function setChannel(NotificationChannelInterface $channel);

    /**
     * @param string $receiver
     */
    function setReceiver($receiver);

    /**
     * @param Event $event
     * @param string $eventName
     */
    function onEvent(Event $event, $eventName);
}
