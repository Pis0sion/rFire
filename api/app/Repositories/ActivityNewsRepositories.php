<?php

namespace App\Repositories;

use App\Dto\ActivityNewsDto;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Repositories\ActivityNewsRepositories
 */
class ActivityNewsRepositories
{
    #[Inject]
    protected ActivityNewsDto $activityNewsDto;

    /**
     * @return Builder[]|Collection
     */
    public function getActivityNewsList()
    {
        return $this->activityNewsDto->getActivityNewsList();
    }
}