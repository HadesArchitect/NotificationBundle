<?php

namespace HadesArchitect\NotificationBundle\Channel;

class EchoChannel implements NotificationChannelInterface
{
    public function send(array $receiver, $data)
    {
        echo $data;
    }
}
