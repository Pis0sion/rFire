<?php

namespace App\Controller\V1;

use App\Repositories\ActivityNewsCategoriesRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * \App\Controller\V1\ActivityNewsCategoriesController
 */
#[Controller(prefix: "/api/v1")]
class ActivityNewsCategoriesController
{

    #[Inject]
    protected ActivityNewsCategoriesRepositories $activityNewsCategoriesRepositories;

    #[RequestMapping(path: "activity-news-categories", methods: "GET")]
    public function getActivityNewsCategories()
    {
        $categories = $this->activityNewsCategoriesRepositories->getActivityNewsCategories();

        return renderResponse($categories);
    }

}