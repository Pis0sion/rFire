<?php

namespace App\Repositories;

use App\Dto\ActivityCategoriesDto;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Repositories\CategoriesRepositories
 */
class CategoriesRepositories
{
    #[Inject]
    protected ActivityCategoriesDto $activityCategoriesDto;

    /**
     * @return Builder[]|Collection
     */
    public function getActivityCategories()
    {
        return $this->activityCategoriesDto->getActivityCategories();
    }
}