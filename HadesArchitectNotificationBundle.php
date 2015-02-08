<?php

namespace HadesArchitect\NotificationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use HadesArchitect\NotificationBundle\DependencyInjection\HadesArchitectNotificationExtension;

class HadesArchitectNotificationBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new HadesArchitectNotificationExtension;
        }

        return $this->extension;
    }
}
