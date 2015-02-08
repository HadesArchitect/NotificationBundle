<?php

namespace HadesArchitect\NotificationBundle\Channel;

interface NotificationChannelInterface
{
    function send(array $receiver, $data);
}
