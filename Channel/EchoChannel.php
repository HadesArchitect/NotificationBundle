<?php

namespace HadesArchitect\NotificationBundle\Channel;

use HadesArchitect\NotificationBundle\Notification\NotificationInterface;

class EchoChannel implements NotificationChannelInterface
{
    public function send(NotificationInterface $notification)
    {
        echo $notification->getBody();
    }
}
