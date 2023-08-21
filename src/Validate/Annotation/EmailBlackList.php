<?php

declare(strict_types=1);

namespace Imi\Email\BlackList\Validate\Annotation;

use Imi\Bean\Annotation;
use Imi\Validate\Annotation\Condition;

/**
 * 邮箱黑名单验证
 *
 * @Annotation
 *
 * @Target({"CLASS", "METHOD", "PROPERTY"})
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class EmailBlackList extends Condition
{
    /**
     * @param callable $callable
     */
    public function __construct(?array $__data = null, ?string $name = null, bool $optional = false, $default = null, bool $inverseResult = false, string $message = 'Email domain baned', $callable = '\Imi\Email\BlackList\Util\EmailBlackListUtil::validateEmail', array $args = [
        '{:value}',
    ], ?string $exception = null, ?int $exCode = null)
    {
        parent::__construct(...\func_get_args());
    }
}
