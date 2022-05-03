<?php

namespace App\Controller\V1;

use App\Repositories\CategoriesRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * \App\Controller\V1\ActivityCategoriesController
 */
#[Controller(prefix: "/api/v1")]
class ActivityCategoriesController
{

    #[Inject]
    protected CategoriesRepositories $categoriesRepositories;

    #[RequestMapping(path: "activity-categories", methods: "GET")]
    public function getActivityCategoriesList()
    {
        $activityCategories = $this->categoriesRepositories->getActivityCategories();

        return renderResponse($activityCategories);
    }


}