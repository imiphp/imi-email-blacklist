# imi-email-blacklist

[![Latest Version](https://img.shields.io/packagist/v/imiphp/imi-email-blacklist.svg)](https://packagist.org/packages/imiphp/imi-email-blacklist)
[![Php Version](https://img.shields.io/badge/php-%3E=7.4-brightgreen.svg)](https://secure.php.net/)
[![Swoole Version](https://img.shields.io/badge/swoole-%3E=4.8.0-brightgreen.svg)](https://github.com/swoole/swoole-src)
[![imi License](https://img.shields.io/badge/license-MulanPSL%202.0-brightgreen.svg)](https://github.com/imiphp/imi-email-blacklist/blob/master/LICENSE)

## 介绍

imi 框架邮箱域名黑名单组件，支持自动更新临时邮箱域名列表。

## 安装

`composer require imiphp/imi-email-blacklist:~2.1.0`

## 使用说明

### 数据更新

**配置：**

`@app.beans`：

```php
[
    \Imi\Email\BlackList\EmailBlackListHandler::class => [
        'handler' => \Imi\Email\BlackList\Handler\RedisHandler::class, // 数据处理器，目前仅支持 Redis，你也可以实现 \Imi\Email\BlackList\IHandler 接口自定义处理器
    ],
    \Imi\Email\BlackList\EmailBlackListCrawler::class => [
        'enable' => true, // 是否启用
        // 采集器列表
        // 你也可以实现 \Imi\Email\BlackList\Contract\IEmailBlackListCrawler 接口自定义采集器
        'crawlers' => [
            \Imi\Email\BlackList\IvoloDisposableEmailDomainsCrawler::class, // 数据来源：https://github.com/ivolo/disposable-email-domains/raw/master/index.json
        ],
    ],
    // handler 配置
    \Imi\Email\BlackList\Handler\RedisHandler::class => [
        'key' => 'imi:email:blacklist', // 存储数据的键名
        'poolName' => null, // 连接池
    ],
]
```

> 上面展示的是默认配置，默认不配置也可以使用

**定时自动采集：**

由于列表频繁更新可能性不大，固定 1 小时采集一次。你必须启用定时任务进程。

**手动更新采集：**

运行命令：`vendor/bin/imi-swoole emailBlackList/crawl`

> `imi-swoole` 也可以替换为其它容器的启动文件

### 自定义管理域名

```php
$handler = \Imi\Email\BlackList\Util\EmailBlackListUtil::getHandler();
$handler->add(['example.com']); // 批量增加
$handler->remove(['example.com']); // 批量删除
$handler->clear(); // 清空
$handler->has('example.com'); // 是否存在
$handler->count(); // 统计数量
$handler->list(); // 获取列表
$handler->list('.com'); // 关键词搜索
// 分页
// 注意：RedisHandler 返回数据数量可能不一定等于 $count
$page = 1;
$count = 10;
$handler->list('', $page, $count);
```

### 验证器

注解：`Imi\Email\BlackList\Validate\Annotation\EmailBlackList`

```php
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
```

### 手动验证

```php
// 不在黑名单中返回 true，否则返回 false
\Imi\Email\BlackList\Util\EmailBlackListUtil::validateEmail('a@example.com');
```

## 免费技术支持

技术支持详见：<https://doc.imiphp.com/v2.1/base/support.html>

## 运行环境

* [PHP](https://php.net/) >= 7.4
* [Composer](https://getcomposer.org/) >= 2.0
* [Swoole](https://www.swoole.com/) >= 4.8.0
* [imi](https://www.imiphp.com/) >= 2.1

## 版权信息

`imi-email-blacklist` 遵循 MulanPSL-2.0 开源协议发布，并提供免费使用。

## 捐赠

<img src="https://cdn.jsdelivr.net/gh/imiphp/imi@2.1/res/pay.png"/>

开源不求盈利，多少都是心意，生活不易，随缘随缘……
