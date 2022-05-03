<?php

namespace App\Controller\V1;

use App\Exception\ParametersException;
use App\Repositories\ActivityRepositories;
use App\Repositories\UserRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix: "/api/v1")]
class UserController
{
    #[Inject]
    protected UserRepositories $userRepositories;

    #[Inject]
    protected ActivityRepositories $activityRepositories;


    #[RequestMapping(path: 'user-login', methods: 'POST')]
    public function login(RequestInterface $request)
    {
        $openId = $request->input('token');
        $userInfo = $request->inputs(['userAvatar', 'userName']);
        $this->userRepositories->createUser($openId, $userInfo);

        return renderResponse();
    }

    /**
     * @throws ParametersException
     */
    #[RequestMapping(path: 'get-user-info', methods: 'POST')]
    public function getUserInfo(RequestInterface $request)
    {
        $openId = $request->input("token");
        $userinfo = $this->userRepositories->getUserInfo($openId);

        return renderResponse($userinfo);

    }

    #[RequestMapping(path: "bind-user-info", methods: "POST")]
    public function bind2Username(RequestInterface $request)
    {
        $openId = $request->input('token');
        $userInfo = $request->inputs(['userAvatar', 'userName']);
        $this->userRepositories->bindUserInfo($openId, $userInfo);

        return renderResponse();
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

    /**
     * 我报名的活动列表
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ParametersException
     */
    #[RequestMapping(path: "my-activity-list", methods: "POST")]
    public function myActivityList(RequestInterface $request)
    {
        $openId = $request->input("token");
        $myActivityList = $this->userRepositories->myActivityList($openId);

        return renderResponse($myActivityList);
    }

    /**
     * 我参赛的活动列表
     * @param RequestInterface $request
     * @return void
     */
    #[RequestMapping(path: "my_enroll_activity", methods: "POST")]
    public function myEnrollActivity(RequestInterface $request)
    {
        $openId = $request->input("token");
        return renderResponse($this->activityRepositories->myList($openId, true));
    }


}