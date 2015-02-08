<?php

/*
 * This file is part of the HadesArchitect Notification bundle
 *
 * (c) Aleksandr Volochnev <a.volochnev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HadesArchitect\NotificationBundle\Handler;

use Symfony\Component\Translation\TranslatorInterface;

interface TranslatorAwareHandlerInterface
{
    /**
     * @param TranslatorInterface $translator
     */
    function setTranslator(TranslatorInterface $translator);
}
