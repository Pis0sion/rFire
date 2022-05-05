<?php

namespace App\Controller\V1;

use App\Exception\ParametersException;
use App\Repositories\ActivityNewsRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * \App\Controller\V1\ActivityNewsController
 */
#[Controller(prefix: "/api/v1")]
class ActivityNewsController
{
    #[Inject]
    protected ActivityNewsRepositories $activityNewsRepositories;

    #[RequestMapping(path: "activity-news-list", methods: "GET")]
    public function getActivityHomeNewsList()
    {
        $activityNews = $this->activityNewsRepositories->getActivityHomeNewsList();
        return renderResponse($activityNews);
    }

    #[RequestMapping(path: "activity-news-all", methods: "POST")]
    public function getActivityNewsList(RequestInterface $request)
    {
        $searchParams = $request->inputs(["categoryID"]);

        $activityNews = $this->activityNewsRepositories->getActivityNewsList(array_filter($searchParams));
        return renderResponse(paginate($activityNews));
    }

    /**
     * @throws ParametersException
     */
    #[RequestMapping(path: "activity-news-details/{activityNewsID}", methods: "GET")]
    public function getActivityNewsDetails(int $activityNewsID)
    {
        $activityNewsDetails = $this->activityNewsRepositories->getActivityNewsDetails($activityNewsID);

        return renderResponse($activityNewsDetails);
    }
}