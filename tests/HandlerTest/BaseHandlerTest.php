<?php

declare(strict_types=1);

namespace Imi\Email\BlackList\Test\HandlerTest;

use Imi\App;
use Imi\Email\BlackList\Handler\IHandler;
use PHPUnit\Framework\TestCase;

abstract class BaseHandlerTest extends TestCase
{
    protected string $handlerClass;

    public function test(): void
    {
        $handler = $this->getHandler();
        $handler->clear();
        $this->assertEquals(0, $handler->count());

        $handler->add(['a.com', 'b.cn']);
        $this->assertEquals(2, $handler->count());

        $this->assertTrue($handler->has('a.com'));
        $this->assertTrue($handler->has('b.cn'));
        $this->assertFalse($handler->has('c.com'));

        $this->assertCount(2, $list = $handler->list());
        $this->assertContains('a.com', $list);
        $this->assertContains('b.cn', $list);

        $this->assertCount(1, $list = $handler->list('a'));
        $this->assertContains('a.com', $list);

        $this->assertCount(1, $list = $handler->list('a', 1, 1));
        $this->assertContains('a.com', $list);

        $this->assertCount(0, $list = $handler->list('a', 2, 1));

        $handler->remove(['a.com']);
        $this->assertEquals(1, $handler->count());
        $this->assertFalse($handler->has('a.com'));
        $this->assertTrue($handler->has('b.cn'));
    }

    protected function getHandler(): IHandler
    {
        return App::getBean($this->handlerClass);
    }
}
