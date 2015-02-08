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
use HadesArchitect\NotificationBundle\Exception\ChannelException;
use HadesArchitect\NotificationBundle\Exception\TemplatingException;
use HadesArchitect\NotificationBundle\Notification\Notification;
use HadesArchitect\NotificationBundle\Notification\NotificationInterface;
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

    /**
     * @inheritdoc
     */
    function setTemplatingEngine(EngineInterface $engine)
    {
        $this->templatingEngine = $engine;
    }

    /**
     * @inheritdoc
     */
    function setChannel(NotificationChannelInterface $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * @inheritdoc
     */
    public function onEvent(Event $event, $eventName)
    {
        $view = $this->templatingEngine->render(
            $this->templateName, array(
                'event_name' => $eventName,
                'event'      => $event,
                'receiver'   => $this->receiver
            )
        );

        try {
            $this->channel->send($this->getNotification($view));
        } catch (\Exception $exception) {
            throw new ChannelException('Exception was caught during notification sending', 0, $exception);
        }
    }

    /**
     * @param string $body
     *
     * @return NotificationInterface
     */
    protected function getNotification($body)
    {
        $notification = new Notification();

        $notification
            ->setReceiver($this->receiver)
            ->setBody($body);

        return $notification;
    }
}
