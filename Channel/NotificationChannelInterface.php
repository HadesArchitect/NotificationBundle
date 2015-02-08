<?php

namespace HadesArchitect\NotificationBundle\Channel;

use HadesArchitect\NotificationBundle\Notification\NotificationInterface;

interface NotificationChannelInterface
{
    function send(NotificationInterface $notification);
}
