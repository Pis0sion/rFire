<?php

namespace App\Controller\V1;

use App\Exception\ParametersException;
use App\Repositories\ActivityRepositories;
use App\Servlet\AsyncActivityServlet;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller(prefix: '/api/v1')]
class ActivityController
{
    #[Inject]
    protected ActivityRepositories $activityRepositories;

    #[Inject]
    protected AsyncActivityServlet $asyncActivityServlet;

    #[RequestMapping(path: "activity-home-list", methods: "GET")]
    public function activityList()
    {
        $activityList = $this->activityRepositories->activityLatestByList();
        return renderResponse($activityList);
    }

    /**
     * @throws ParametersException
     */
    #[RequestMapping(path: "activity-details/{activityID}", methods: "GET")]
    public function activity2Details(int $activityID)
    {
        $activityDetails = $this->activityRepositories->activity2Details($activityID);
        return renderResponse($activityDetails);
    }

    #[RequestMapping(path: "activity-push", methods: "GET")]
    public function pushActivity()
    {
        $this->asyncActivityServlet->push(["activityID" => 4, "activityStatus" => 1], 10);
        return renderResponse();
    }

    #[RequestMapping(path: "activity-list", methods: "POST")]
    public function activityListByCondition(RequestInterface $request)
    {
        $search = $request->inputs(["startTime", "endTime", "categoryID", "organizerID", "typeID", "startEnrollAt", "endEnrollAt"]);
        return $this->activityRepositories->getListBySearch($search);
    }

}