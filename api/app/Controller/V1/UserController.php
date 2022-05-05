<?php

namespace App\Controller\V1;

use App\Exception\ParametersException;
use App\Exception\TimeOutException;
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


    /**
     * @throws ParametersException
     */
    #[RequestMapping(path: "get-user-info", methods: "POST")]
    public function getUserInfo(RequestInterface $request)
    {
        $openId = $request->input("token");
        $userinfo = $this->userRepositories->getUserInfo($openId);

        return renderResponse($userinfo);

    }

    #[RequestMapping(path: "bind-user-info", methods: "POST")]
    public function bind2Username(RequestInterface $request)
    {
        $openId = $request->input("token");
        $userInfo = $request->inputs(["userAvatar", "userName", "age", "sex", "phone", "cardID"]);

        $this->userRepositories->bindUserInfo($openId, array_filter($userInfo));
        return renderResponse();
    }

    /**
     * @throws ParametersException
     * @throws TimeOutException
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
    #[RequestMapping(path: "enroll-activity-list", methods: "POST")]
    public function myActivityList(RequestInterface $request)
    {
        $openId = $request->input("token");
        $myActivityList = $this->userRepositories->myActivityList($openId);

        return renderResponse($myActivityList);
    }

    /**
     * @param RequestInterface $request
     * @return void
     * @throws ParametersException
     */
    #[RequestMapping(path: "pending-activity-list", methods: "POST")]
    public function myPendingActivity(RequestInterface $request)
    {
        $openId = $request->input("token");
        $pendingActivityList = $this->userRepositories->myPendingActivityList($openId);

        return renderResponse($pendingActivityList);
    }

    /**
     * @param RequestInterface $request
     * @return void
     * @throws ParametersException
     */
    #[RequestMapping(path: "participated-activity-list", methods: "POST")]
    public function myParticipatedActivity(RequestInterface $request)
    {
        $openId = $request->input("token");
        $participatedActivityList = $this->userRepositories->myParticipatedActivityList($openId);

        return renderResponse($participatedActivityList);
    }

}