<?php

namespace App\Repositories;

use App\Dto\ActivityDto;
use Hyperf\Contract\LengthAwarePaginatorInterface;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Repositories\ActivityRepositories
 */
class ActivityRepositories
{
    #[Inject]
    protected ActivityDto $activityDto;

    /**
     * @return Builder[]|Collection
     */
    public function activityLatestByList()
    {
        return $this->activityDto->activityLatestByList();
    }

    /**
     *
     * @param string $openId
     * @return LengthAwarePaginatorInterface
     */
    public function myList(string $openId)
    {
        return $this->activityDto->myList($openId);
    }

}