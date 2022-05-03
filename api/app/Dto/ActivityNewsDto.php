<?php

namespace App\Dto;

use App\Model\ActivityNewsModel;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Dto\ActivityNewsDto
 */
class ActivityNewsDto
{

    #[Inject]
    protected ActivityNewsModel $activityNewsModel;

    /**
     * @return Builder[]|Collection
     */
    public function getActivityNewsList()
    {
        $selectFields = ["id", "title", "desc", "cover", "createdAt"];
        return $this->activityNewsModel->newQuery()->limit(5)->orderByDesc("createdAt")->get($selectFields);
    }

}