<?php

declare(strict_types=1);

namespace app\Module\Service;

use Imi\Email\BlackList\Validate\Annotation\EmailBlackList;
use Imi\Validate\Annotation\AutoValidation;

class TestService
{
    /**
     * @AutoValidation
     *
     * @EmailBlackList(name="email")
     */
    public function testEmail(string $email): void
    {
    }
}
