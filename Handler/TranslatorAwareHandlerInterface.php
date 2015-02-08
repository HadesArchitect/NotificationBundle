<?php

namespace HadesArchitect\NotificationBundle\Handler;

use Symfony\Component\Translation\TranslatorInterface;

interface TranslatorAwareHandlerInterface
{
    /**
     * @param TranslatorInterface $translator
     */
    function setTranslator(TranslatorInterface $translator);
}
