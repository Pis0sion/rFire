<?php

namespace App\Repositories;

use App\Dto\ActivityDto;
use App\Exception\ParametersException;
use Hyperf\Contract\LengthAwarePaginatorInterface;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
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
     * @param int $activityID
     * @return Builder|Model|object
     * @throws ParametersException
     */
    public function activity2Details(int $activityID)
    {
        $activity = $this->activityDto->getActivityDetails($activityID);

        if (is_null($activity)) {
            throw new ParametersException();
        }

        return $activity->load(["organizers" => function ($query) {
            $query->select(["id", "name"]);
        }]);
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