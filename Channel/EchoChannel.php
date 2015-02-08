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

class EchoChannel implements NotificationChannelInterface
{
    /**
     * @inheritdoc
     */
    public function send(NotificationInterface $notification)
    {
        echo $notification->getBody();
    }
}
