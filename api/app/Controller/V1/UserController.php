<?php

namespace App\Controller\V1;

use App\Exception\ParametersException;
use App\Repositories\UserRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller(prefix: "/api/v1")]
class UserController
{
    #[Inject]
    protected UserRepositories $userRepositories;

    #[RequestMapping(path: 'user-login', methods: 'POST')]
    public function login(RequestInterface $request)
    {
        $openId = $request->input('token');
        $userInfo = $request->inputs(['userAvatar', 'userName']);
        return renderResponse($this->userRepositories->createUser($openId, $userInfo));
    }

    #[RequestMapping(path: 'get-user-info', methods: 'POST')]
    public function getUserInfo(RequestInterface $request)
    {
        $openId = $request->input("token");
        return renderResponse($this->userRepositories->getUserInfo($openId));

    }

    #[RequestMapping(path: 'bind-user-info', methods: 'POST')]
    public function bind2Username(RequestInterface $request)
    {
        $openId = $request->input('token');
        $userInfo = $request->inputs(['userAvatar', 'userName']);
        return renderResponse($this->userRepositories->bindUserInfo($openId, $userInfo));
    }

    #[RequestMapping(path: 'edit-user-info', methods: 'POST')]
    public function editUserInfo(RequestInterface $request)
    {
        $openID = $request->input('token');
        $userInfo = $request->inputs(['userAvatar', 'userName']);
        return renderResponse($this->userRepositories->bindUserInfo($openID, $userInfo));
    }

    /**
     * @throws ParametersException
     */
    #[RequestMapping(path: "activity-enroll/{activityID}", methods: "POST")]
    public function enroll2Activity(int $activityID, RequestInterface $request)
    {
        $openID = $request->input('token');
        $this->userRepositories->enroll2Activity($openID, $activityID);

        return renderResponse();
    }

}