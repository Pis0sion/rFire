<?php

namespace App\Dto;

use App\Model\ActivityCategoriesModel;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Dto\ActivityCategoriesDto
 */
class ActivityCategoriesDto
{
    #[Inject]
    protected ActivityCategoriesModel $activityCategoriesModel;

    /**
     * @return Builder[]|Collection
     */
    public function getActivityCategories()
    {
        return $this->activityCategoriesModel->newQuery()->orderByDesc("createdAt")->get();
    }

}