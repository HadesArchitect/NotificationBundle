<?php

/*
 * This file is part of the HadesArchitect Notification bundle
 *
 * (c) Aleksandr Volochnev <a.volochnev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

    /**
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @inheritdoc
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @inheritdoc
     */
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
