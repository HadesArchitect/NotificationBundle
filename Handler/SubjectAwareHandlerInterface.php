<?php

namespace HadesArchitect\NotificationBundle\Handler;

interface SubjectAwareHandlerInterface
{
    /**
     * @param string $subject
     */
    function setSubject($subject);
}

