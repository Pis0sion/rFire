<?php

namespace App\Controller\V1;

use App\Exception\ParametersException;
use App\Repositories\LaunchRepositories;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * \App\Controller\V1\LaunchController
 */
#[Controller(prefix: "/api/v1")]
class LaunchController
{
    #[Inject]
    protected LaunchRepositories $launchRepositories;

    /**
     * @throws InvalidConfigException
     * @throws ParametersException
     */
    #[RequestMapping(path: "launch", methods: "GET")]
    public function wechatLaunch(RequestInterface $request)
    {
        $code = $request->input("code");
        return $this->launchRepositories->getAuth2Session($code);
    }


}