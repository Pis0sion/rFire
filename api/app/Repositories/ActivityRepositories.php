<?php

namespace App\Repositories;

use App\Dto\ActivityDto;
use App\Dto\UsersDto;
use App\Exception\ParametersException;
use App\Model\ActivityModel;
use App\Model\UsersModel;
use Carbon\Carbon;
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

    #[Inject]
    protected UsersDto $usersDto;

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
        $activity = $this->activityDto->getActivityDetailsWithOrganizersAndCategories($activityID);

        if (is_null($activity)) {
            throw new ParametersException();
        }

        return $activity;
    }

    /**
     * @param array $conditions
     * @return LengthAwarePaginatorInterface
     */
    public function activityListByCondition(array $conditions)
    {
        return $this->activityDto->activityListByCondition($conditions);
    }


    /**
     * @param string $openID
     * @param int $activityID
     * @return bool
     * @throws ParametersException
     */
    public function isUserParticipate2Activity(string $openID, int $activityID)
    {
        /**
         * @var UsersModel $userInfo
         */
        $userInfo = $this->usersDto->getUserInfo($openID);

        if (is_null($userInfo)) {
            throw new ParametersException(errMessage: "当前用户不存在或者已被删除...");
        }

        /**
         * @var ActivityModel $activity
         */
        $activity = $this->activityDto->getActivityDetails($activityID);

        if (is_null($activity)) {
            throw new ParametersException(errMessage: "当前活动不存在或者已删除...");
        }

        return $userInfo->whetherUserParticipatesInActivity($activity);
    }

    /**
     * @param array $activityParameters
     * @return bool
     * @throws ParametersException
     */
    public function createActivityByManager(array $activityParameters)
    {

        if (Carbon::now()->gte(Carbon::parse($activityParameters["startEnrollAt"]))) {
            throw new ParametersException(errMessage: "报名时间不能晚于当前时间...");
        }

        if (Carbon::parse($activityParameters["startEnrollAt"])->gt(Carbon::parse($activityParameters["endEnrollAt"]))) {
            throw new ParametersException("报名开始时间不能晚于报名结束时间...");
        }

        if (Carbon::parse($activityParameters["endEnrollAt"])->gt(Carbon::parse($activityParameters["startAt"]))) {
            throw new ParametersException("报名结束时间不能晚于活动开始时间...");
        }

        if (Carbon::parse($activityParameters["startAt"])->gt(Carbon::parse($activityParameters["endAt"]))) {
            throw new ParametersException("活动开始时间不能晚于活动结束时间...");
        }

        return $this->activityDto->createActivity($activityParameters);
    }

}