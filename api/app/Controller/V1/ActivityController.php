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
    #[RequestMapping(path: "activity-details/{activityID}", methods: ["POST", "GET"])]
    public function activity2Details(RequestInterface $request, int $activityID)
    {
        $openID = $request->input("token", null);
        $activityDetails = $this->activityRepositories->activity2Details($activityID, $openID);

        return renderResponse($activityDetails);
    }

    #[RequestMapping(path: "activity-list", methods: "POST")]
    public function activityListByCondition(RequestInterface $request)
    {
        $searchParams = $request->inputs(["categoryID", "organizerID", "typeID", "status"]);
        $activityList = $this->activityRepositories->activityListByCondition(array_filter($searchParams));
        return renderResponse(paginate($activityList));
    }

    #[RequestMapping(path: "activity-push", methods: "POST")]
    public function createActivity(RequestInterface $request)
    {
        $activityParameters = $request->inputs(["activityID", "activityStatus"]);
        $this->asyncActivityServlet->push($activityParameters);
        return renderResponse();
    }

    #[RequestMapping(path: "start-activity/{activityID}", methods: "POST")]
    public function startActivity2Go(int $activityID,RequestInterface $request)
    {
        $token = $request->input("token");

        $this->activityRepositories->start2GoActivity($token, $activityID);
        return renderResponse();
    }


}