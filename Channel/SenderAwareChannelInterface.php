<?php

namespace HadesArchitect\NotificationBundle\Channel;

interface SenderAwareChannelInterface
{
    function setSender($sender);
}
