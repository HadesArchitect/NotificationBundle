<?php

/*
 * This file is part of the HadesArchitect Notification bundle
 *
 * (c) Aleksandr Volochnev <a.volochnev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class BaseHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \HadesArchitect\NotificationBundle\Handler\HandlerInterface
     */
    protected $handler;

    public function setUp()
    {
        $this->handler = new \HadesArchitect\NotificationBundle\Handler\BaseHandler();
    }

    public function testTemplatePriorityFail()
    {
        $this->setExpectedException('\HadesArchitect\NotificationBundle\Exception\TemplatingException');

        $this->handler->setTemplateName('123');
    }

    public function testTemplateNotSupportedFail()
    {
        $this->setExpectedException('\HadesArchitect\NotificationBundle\Exception\TemplateNotSupportedException');

        $stub = $this->getMock('\Symfony\Component\Templating\EngineInterface');

        $this->handler->setTemplatingEngine($stub);
        $this->handler->setTemplateName('123');
    }

    public function testTemplateSuccess()
    {
        $stub = $this->getMock('\Symfony\Component\Templating\EngineInterface');

        $stub->method('supports')
            ->willReturn(true);

        $this->handler->setTemplatingEngine($stub);
        $this->handler->setTemplateName('123');
    }
}
