<?php

namespace App\Controller\V1;

use App\Repositories\AuthorityRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller(prefix: '/api/v1')]
class RoleController
{
    #[Inject]
    protected AuthorityRepositories $authorityRepositories;

    #[RequestMapping(path: 'get-user-list')]
    public function getUserByRoleID(RequestInterface $request)
    {
        $token = $request->input('token');
        $roleID = $request->input('roleID');

    }
}