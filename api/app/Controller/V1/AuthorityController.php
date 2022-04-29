<?php

namespace App\Controller\V1;

use App\Repositories\AuthorityRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller(prefix: '/api/v1')]
class AuthorityController
{
    #[Inject]
    protected AuthorityRepositories $authorityRepositories;

    #[RequestMapping(path: 'get-authlist',methods: 'GET')]
    public function getAuthList(RequestInterface $request)
    {
        $token = $request->input('token','');
        //根据token获得用户信息并获得用户的权限列表
        $userID = 1;
        return renderResponse($this->authorityRepositories->getAuthByUserID($userID));

    }

}