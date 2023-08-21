<?php

declare(strict_types=1);

namespace Imi\Email\BlackList\Test\HandlerTest;

class RedisHandlerTest extends BaseHandlerTest
{
    protected string $handlerClass = \Imi\Email\BlackList\Handler\RedisHandler::class;
}
