<?php

declare(strict_types=1);

namespace app\ApiServer\Controller;

use Imi\App;
use Imi\Controller\HttpController;
use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;

/**
 * @Controller("/")
 */
class IndexController extends HttpController
{
    /**
     * @Action
     *
     * @Route("/")
     */
    public function index(): mixed
    {
        App::getBean(\Imi\Email\BlackList\EmailBlackListCrawler::class);
        $this->response->getBody()->write('imi');

        return $this->response;
    }
}
