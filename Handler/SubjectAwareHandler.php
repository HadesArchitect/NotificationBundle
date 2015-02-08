<?php

namespace HadesArchitect\NotificationBundle\Handler;

use HadesArchitect\NotificationBundle\Notification\Notification;
use Symfony\Component\Translation\TranslatorInterface;

class SubjectAwareHandler extends BaseHandler implements SubjectAwareHandlerInterface, TranslatorAwareHandlerInterface
{
    /**
     * @var string
     */
    protected $subject;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    protected function getNotification($body)
    {
        $notification = new Notification();

        $notification
            ->setReceiver($this->receiver)
            ->setSubject($this->translator->trans($this->subject))
            ->setBody($body);

        return $notification;
    }
}
