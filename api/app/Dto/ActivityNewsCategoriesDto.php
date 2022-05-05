<?php

namespace App\Dto;

use App\Model\ActivityNewsCategoryModel;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Dto\ActivityNewsCategoriesDto
 */
class ActivityNewsCategoriesDto
{

    #[Inject]
    protected ActivityNewsCategoryModel $activityNewsCategoryModel;

    /**
     * @return Builder[]|Collection
     */
    public function getActivityNewsCategories()
    {
        return $this->activityNewsCategoryModel->newQuery()->select(["id", "name"])
            ->orderByDesc("sort")->orderByDesc("createdAt")->get();
    }
}