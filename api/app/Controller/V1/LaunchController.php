<?php

namespace App\Controller\V1;

use App\Repositories\LaunchRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * \App\Controller\V1\LaunchController
 */
#[Controller(prefix: "/api/v1/")]
class LaunchController
{
    #[Inject]
    protected LaunchRepositories $launchRepositories;

    #[RequestMapping(path: "launch", methods: "POST")]
    public function wechatLaunch(RequestInterface $request)
    {
        $code = $request->input("code");
        return $this->launchRepositories->getAuth2Session($code);
    }


}