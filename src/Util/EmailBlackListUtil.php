<?php

declare(strict_types=1);

namespace Imi\Email\BlackList\Util;

use Imi\App;
use Imi\Email\BlackList\EmailBlackListHandler;
use Imi\Email\BlackList\Handler\IHandler;
use Imi\Util\Traits\TStaticClass;

class EmailBlackListUtil
{
    use TStaticClass;

    public static function getHandler(): IHandler
    {
        return App::getBean(EmailBlackListHandler::class)->getInstance();
    }

    public static function validateEmail(string $email): bool
    {
        @[, $domain] = explode('@', $email, 2);
        if ('' === $domain)
        {
            return false;
        }

        return !self::getHandler()->has($domain);
    }
}
