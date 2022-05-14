<?php

namespace App\Dto;

use App\Model\RegistrationModel;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;
use function _PHPStan_76800bfb5\React\Promise\Stream\first;

/**
 * \App\Dto\RegistrationDto
 */
class RegistrationDto
{
    #[Inject]
    protected RegistrationModel $registrationModel;

    /**
     * @param int $activityID
     * @param int $userID
     * @return int
     */
    public function start2GoActivity(int $activityID, int $userID)
    {
        return $this->registrationModel->newQuery()->where("activityID", $activityID)
            ->where("userID", $userID)->update(["isActivity" => 1]);
    }


    /**
     * @param int $activityID
     * @param int $userID
     */
    public function isJoinActivity(int $activityID, int $userID)
    {
        return $this->registrationModel->newQuery()->where("activityID", $activityID)
            ->where("userID", $userID)->where("isActivity", 1)->first();
    }

    /**
     * @param int $activityID
     * @param int $userID
     * @return Builder|Model|object|null
     */
    public function joinActivityDetails(int $activityID, int $userID)
    {
        return $this->registrationModel->newQuery()->where("activityID", $activityID)->where("userID", $userID)->first();
    }
}