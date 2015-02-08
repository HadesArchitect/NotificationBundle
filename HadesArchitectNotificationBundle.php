<?php

/*
 * This file is part of the HadesArchitect Notification bundle
 *
 * (c) Aleksandr Volochnev <a.volochnev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HadesArchitect\NotificationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use HadesArchitect\NotificationBundle\DependencyInjection\HadesArchitectNotificationExtension;

class HadesArchitectNotificationBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new HadesArchitectNotificationExtension;
        }

        return $this->extension;
    }
}
