<?php

namespace HadesArchitect\NotificationBundle\Channel;

use HadesArchitect\NotificationBundle\Notification\NotificationInterface;

class SwiftmailerChannel implements NotificationChannelInterface, SenderAwareChannelInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $sender;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    public function send(NotificationInterface $notification)
    {
        $message = $this->mailer->createMessage()
            ->setFrom($this->sender)
            ->setTo($notification->getReceiver())
            ->setSubject($notification->getSubject())
            ->setBody($notification->getBody(), 'text/html');

        $this->mailer->send($message);
    }
}
