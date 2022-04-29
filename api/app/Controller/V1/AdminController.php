<?php

namespace App\Controller\V1;

use App\Repositories\AdminRepositories;
use App\Repositories\AuthorityRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller(prefix: '/api/v1')]
class AdminController
{
    #[Inject]
    protected AdminRepositories $adminRepositories;

    #[Inject]
    protected AuthorityRepositories $authorityRepositories;

    #[RequestMapping(path: 'login', methods: 'POST')]
    public function login(RequestInterface $request)
    {
        $userName = $request->input('userName');
        $password = $request->input('password');
        $token = $this->adminRepositories->login($userName, $password);
        if ($token) {
            renderResponse($token);
        }
    }

    #[RequestMapping(path:'get-role-list', methods: 'GET' )]
    public function getRoleByUserID(RequestInterface $request)
    {
        $token = $request->input('token');
        $userID = 2;
        return renderResponse($this->authorityRepositories->getRoleByUserID($userID));
    }

    #[RequestMapping(path: 'is-in-roles',methods: 'GET')]
    public  function isInRoles(RequestInterface $request)
    {
        $token = $request->input('token');
        $userID = 2;
        return renderResponse($this->authorityRepositories->isInRoles($userID));
    }

    #[RequestMapping(path: "add-admin", methods: "POST")]
    public function addAdmin()
    {

    }

    public function editAdmin()
    {

    }

    public function adminList()
    {

    }

    public function delAdmin()
    {

    }

    public function detail()
    {

    }
}