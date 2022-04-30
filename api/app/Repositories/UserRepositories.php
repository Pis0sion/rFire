<?php

namespace App\Repositories;

use App\Dto\ActivityDto;
use App\Dto\UsersDto;
use App\Exception\ParametersException;
use App\Model\ActivityModel;
use App\Model\UsersModel;
use Carbon\Carbon;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;

class UserRepositories
{
    #[Inject]
    protected UsersDto $usersDto;

    #[Inject]
    protected ActivityDto $activityDto;

    public function createUser(string $openId, array $data)
    {
        return $this->usersDto->createOrFindUserByOpenID($openId, $data);
    }

    public function getUserInfo(string $openId)
    {
        $userInfo = $this->usersDto->getUserInfo($openId);
        if (is_null($userInfo)) {
            throw  new ParametersException(errMessage: "用户不存在");
        }
        return $userInfo;
    }

    public function bindUserInfo(string $openId, array $userData)
    {
        return $this->usersDto->bindUserInfo($openId, $userData);
    }

    /**
     * @param string $openID
     * @param int $activityID
     * @return Model
     * @throws ParametersException
     */
    public function enroll2Activity(string $openID, int $activityID)
    {
        /**
         * @var UsersModel $userInfo
         */
        $userInfo = $this->usersDto->getUserInfo($openID);

        if (is_null($userInfo)) {
            throw  new ParametersException(errMessage: "当前用户不存在或者已被删除...");
        }

        /**
         * @var ActivityModel $activity
         */
        $activity = $this->activityDto->getActivityDetails($activityID);

        if (is_null($activity)) {
            throw  new ParametersException(errMessage: "当前活动不存在或者已删除...");
        }

        if ($userInfo->whetherUserParticipatesInActivity($activity)) {
            throw  new ParametersException(errMessage: "当前用户已参与过该活动，不能重复报名...");
        }

        if (Carbon::now()->gte(Carbon::parse($activity->startEnrollAt)) && Carbon::now()->lt(Carbon::parse($activity->endEnrollAt))) {
            return $userInfo->signUpActivity($activity, ["score" => 0]);
        }

        throw new ParametersException(errMessage: "当前不在活动报名时间内...");
    }

}