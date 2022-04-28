<?php

namespace App\Controller\V1;

use App\Exception\ParametersException;
use App\Repositories\ActivityRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller(prefix: '/api/v1')]
class ActivityController
{
    #[Inject]
    protected ActivityRepositories $activityRepositories;

    #[RequestMapping(path: "activity-home-list", methods: "GET")]
    public function activityList()
    {
        return renderResponse($this->activityRepositories->activityLatestByList());
    }

    /**
     * @throws ParametersException
     */
    #[RequestMapping(path: "activity-details/{activityID}", methods: "GET")]
    public function activity2Details(int $activityID)
    {
        return renderResponse($this->activityRepositories->activity2Details($activityID));
    }

    #[RequestMapping(path: "activity-enroll", methods: "POST")]
    public function enroll2Activity(RequestInterface $request)
    {

    }

//    #[RequestMapping(path: "activity-list", methods: "GET")]
//    public function activityList(RequestInterface $request)
//    {
//        $search = $request->inputs(['category']);
//        return renderResponse($this->activityRepositories->list($search));
//    }

    #[RequestMapping(path: "my-activity-list", methods: "GET")]
    public function myActivityList(RequestInterface $request)
    {
        $openId = $request->input("token");
        return renderResponse($this->activityRepositories->myList($openId));
    }

}