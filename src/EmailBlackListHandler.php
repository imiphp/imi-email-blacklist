<?php

declare(strict_types=1);

namespace Imi\Email\BlackList;

use Imi\App;
use Imi\Email\BlackList\Handler\IHandler;

class EmailBlackListHandler
{
    protected string $handler = \Imi\Email\BlackList\Handler\RedisHandler::class;

    public function getHandler(): string
    {
        return $this->handler;
    }

    public function getInstance(): IHandler
    {
        return App::getBean($this->handler);
    }
}
