<?php

namespace App\Controller\V1;

use App\Repositories\ActivityNewsRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * \App\Controller\V1\ActivityNewsController
 */
#[Controller(prefix: "/api/v1")]
class ActivityNewsController
{
    #[Inject]
    protected ActivityNewsRepositories $activityNewsRepositories ;

    #[RequestMapping(path: "activity-news-list", methods: "GET")]
    public function getActivityNewsList()
    {
        $activityNews = $this->activityNewsRepositories->getActivityNewsList();
        return renderResponse($activityNews);
    }
}