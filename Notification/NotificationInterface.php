<?php

/*
 * This file is part of the HadesArchitect Notification bundle
 *
 * (c) Aleksandr Volochnev <a.volochnev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HadesArchitect\NotificationBundle\Notification;

interface NotificationInterface
{
    /**
     * @param string $receiver
     *
     * @return self
     */
    function setReceiver($receiver);

    /**
     * @param string $subject
     *
     * @return self
     */
    function setSubject($subject);

    /**
     * @param string $body
     *
     * @return self
     */
    function setBody($body);

    /**
     * @return string
     */
    function getReceiver();

    /**
     * @return string
     */
    function getSubject();

    /**
     * @return string
     */
    function getBody();
}
