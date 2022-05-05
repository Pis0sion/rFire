<?php

namespace App\Repositories;

use App\Dto\ActivityNewsCategoriesDto;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Repositories\ActivityNewsCategoriesRepositories
 */
class ActivityNewsCategoriesRepositories
{

    #[Inject]
    protected ActivityNewsCategoriesDto $activityNewsCategoriesDto;

    /**
     * @return Builder[]|Collection
     */
    public function getActivityNewsCategories()
    {
        return $this->activityNewsCategoriesDto->getActivityNewsCategories();
    }
}