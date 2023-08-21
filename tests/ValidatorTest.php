<?php

declare(strict_types=1);

namespace Imi\Email\BlackList\Test;

use app\Module\Service\TestService;
use Imi\App;
use Imi\Email\BlackList\EmailBlackListHandler;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testEmailBlackListAnnotation(): void
    {
        $handler = App::getBean(EmailBlackListHandler::class)->getInstance();
        $handler->add(['imiphp.com']);

        $testService = App::getBean(TestService::class);
        $testService->testEmail('a@b.com');
        try
        {
            $testService->testEmail('a@imiphp.com');
            $this->assertTrue(false);
        }
        catch (\InvalidArgumentException $e)
        {
            $this->assertEquals('Email domain baned', $e->getMessage());
        }
    }
}
