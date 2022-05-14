<?php

namespace App\Repositories;

use App\Constants\ActivityStatusConstants;
use App\Dto\ActivityDto;
use App\Dto\RegistrationDto;
use App\Dto\UsersDto;
use App\Exception\ParametersException;
use App\Model\ActivityModel;
use App\Model\UsersModel;
use Carbon\Carbon;
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

    #[Inject]
    protected UsersDto $usersDto;

    #[Inject]
    protected RegistrationDto $registrationDto;

    /**
     * @return Builder[]|Collection
     */
    public function activityLatestByList()
    {
        return $this->activityDto->activityLatestByList();
    }

    /**
     * @param int $activityID
     * @param string|null $openID
     * @return array
     * @throws ParametersException
     */
    public function activity2Details(int $activityID, ?string $openID = null)
    {
        $activity = $this->activityDto->getActivityDetailsWithOrganizersAndCategories($activityID);

        if (is_null($activity)) {
            throw new ParametersException();
        }

        $activity = $activity->toArray();

        if ($openID) {
            $activity = $this->getActivityDetailsByStage($openID, $activityID, $activity);
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

    /**
     * @param string $openID
     * @param int $activityID
     * @throws ParametersException
     */
    public function start2GoActivity(string $openID, int $activityID)
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

        if ($activity->getAttribute("status") != ActivityStatusConstants::END_AT) {
            throw new ParametersException(errMessage: "活动不在进行中的状态...");
        }

        if ($this->registrationDto->isJoinActivity($activityID, (int)$userInfo->getAttribute("id"))) {
            throw new ParametersException(errMessage: "用户已开始参加活动...");
        }

        $activity->incrementAcPersonCount();

        return $this->registrationDto->start2GoActivity($activityID, (int)$userInfo->getAttribute("id"));
    }

    /**
     * @param string $openID
     * @param int $activityID
     * @param array $activity
     * @return array
     * @throws ParametersException
     */
    public function getActivityDetailsByStage(string $openID, int $activityID, array $activity)
    {
        /**
         * @var UsersModel $userInfo
         */
        $userInfo = $this->usersDto->getUserInfo($openID);

        if (is_null($userInfo)) {
            throw new ParametersException(errMessage: "当前用户不存在或者已被删除...");
        }

        $registration = $this->registrationDto->joinActivityDetails($activityID, $userInfo->getAttribute("id"));

        $activityStatus = $activity["status"];
        $isEnrollStatus = $registration ? true : false;
        $isActivityStatus = ($registration && $registration->isActivity == 1) ? true : false;

        $userStatus = $this->activityStatusByUserStatus($activityID, $activityStatus, $isEnrollStatus, $isActivityStatus);
        $activity["activityStatusText"] = $userStatus["activityStatusText"];
        $activity["redirectApi"] = $userStatus["redirectApi"];
        return $activity;
    }

    /**
     * @param int $activityID
     * @param int $activityStatus
     * @param bool $isEnrollStatus
     * @param bool $isActivityStatus
     * @return array
     */
    protected function activityStatusByUserStatus(int $activityID, int $activityStatus, bool $isEnrollStatus, bool $isActivityStatus): array
    {
        $redirectApi = "";
        $activityStatusText = "等待开启报名";

        if ($activityStatus == ActivityStatusConstants::START_ENROLL_AT) {
            return compact("activityStatusText", "redirectApi");
        }

        if ($activityStatus == ActivityStatusConstants::END_ENROLL_AT) {
            $activityStatusText = "报名成功，等待活动开始";
            if (!$isEnrollStatus) {
                $activityStatusText = "立即报名";
                $redirectApi = sprintf("api/v1/activity-enroll/%d", $activityID);
            }
            return compact("activityStatusText", "redirectApi");
        }

        if ($activityStatus == ActivityStatusConstants::START_AT) {
            $activityStatusText = "报名成功，等待活动开始";
            if (!$isEnrollStatus) {
                $activityStatusText = "报名已截至，活动即将开始";
            }
            return compact("activityStatusText", "redirectApi");
        }

        if ($activityStatus == ActivityStatusConstants::END_AT) {
            if ($isEnrollStatus) {
                if ($isActivityStatus) {
                    $activityStatusText = "已参加活动,查看详情";
                    $redirectApi = "查看参加活动详情的接口";
                } else {
                    $activityStatusText = "开始参加活动";
                    $redirectApi = sprintf("api/v1/start-activity/%d", $activityID);
                }
            } else {
                $activityStatusText = "活动火热进行中";
            }
            return compact("activityStatusText", "redirectApi");
        }

        $activityStatusText = "活动已结束";
        return compact("activityStatusText", "redirectApi");
    }

}