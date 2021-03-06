<?php

namespace App\Repositories;

use App\Constants\ActivityStatusConstants;
use App\Dto\ActivityDto;
use App\Dto\UsersDto;
use App\Exception\ParametersException;
use App\Exception\TimeOutException;
use App\Model\ActivityModel;
use App\Model\UsersModel;
use App\Servlet\Distributed2LockServlet;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;

class UserRepositories
{
    #[Inject]
    protected UsersDto $usersDto;

    #[Inject]
    protected ActivityDto $activityDto;

    #[Inject]
    protected Distributed2LockServlet $distributed2LockServlet;


    /**
     * @param string $openId
     * @return Builder|Model|object
     * @throws ParametersException
     */
    public function getUserInfo(string $openId)
    {
        $userInfo = $this->usersDto->getUserInfo($openId);

        if (is_null($userInfo)) {
            throw new ParametersException();
        }

        return $userInfo;
    }

    /**
     * @param string $openId
     * @param array $userData
     * @return int
     */
    public function bindUserInfo(string $openId, array $userData)
    {
        return $this->usersDto->bindUserInfo($openId, $userData);
    }

    /**
     * @param string $openID
     * @return Collection
     * @throws ParametersException
     */
    public function myActivityList(string $openID)
    {
        /**
         * @var UsersModel $users
         */
        $users = $this->usersDto->getUserInfo($openID);

        if (is_null($users)) {
            throw new ParametersException();
        }

        return $users->enrollActivity();
    }

    /**
     * @param string $openID
     * @param int $activityID
     * @return Model
     * @throws ParametersException
     * @throws TimeOutException
     */
    public function enroll2Activity(string $openID, int $activityID)
    {
        /**
         * @var UsersModel $userInfo
         */
        $userInfo = $this->usersDto->getUserInfo($openID);

        if (is_null($userInfo)) {
            throw new ParametersException(errMessage: "???????????????????????????????????????...");
        }

        /**
         * @var ActivityModel $activity
         */
        $activity = $this->activityDto->getActivityDetails($activityID);

        if (is_null($activity)) {
            throw new ParametersException(errMessage: "????????????????????????????????????...");
        }

        return $this->distributed2LockServlet->distributed2Lock("enroll2Lock", function () use ($userInfo, $activity) {

            if ($userInfo->whetherUserParticipatesInActivity($activity)) {
                throw new ParametersException(errMessage: "??????????????????????????????????????????????????????...");
            }

            if ($activity->getAttribute("status") == ActivityStatusConstants::END_ENROLL_AT) {
                return $userInfo->signUpActivity($activity, ["score" => 0]);
            }

            throw new ParametersException(errMessage: "?????????????????????????????????...");
        });
    }

    /**
     * @param string $openID
     * @return Collection
     * @throws ParametersException
     */
    public function myPendingActivityList(string $openID)
    {
        /**
         * @var UsersModel $userInfo
         */
        $userInfo = $this->usersDto->getUserInfo($openID);

        if (is_null($userInfo)) {
            throw new ParametersException(errMessage: "???????????????????????????????????????...");
        }

        return $userInfo->pendingActivity();
    }

    /**
     * @param string $openID
     * @return Collection
     * @throws ParametersException
     */
    public function myParticipatedActivityList(string $openID)
    {
        /**
         * @var UsersModel $userInfo
         */
        $userInfo = $this->usersDto->getUserInfo($openID);

        if (is_null($userInfo)) {
            throw new ParametersException(errMessage: "???????????????????????????????????????...");
        }

        return $userInfo->participateActivity();
    }
}