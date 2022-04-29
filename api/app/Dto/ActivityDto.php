<?php

namespace App\Dto;

use App\Model\ActivityModel;
use App\Model\UsersModel;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Dto\ActivityDto
 */
class ActivityDto
{
    #[Inject]
    protected ActivityModel $activityModel;

    #[Inject]
    protected UsersModel $usersModel;

    /**
     * @param int $activityID
     * @return Builder|Model|object|null
     */
    public function getActivityDetails(int $activityID)
    {
        return $this->activityModel->newQuery()->where("id", $activityID)->first();
    }

    /**
     * @return Builder[]|Collection
     */
    public function activityLatestByList()
    {
        $selectFields = [
            "id", "title", "desc", "cover", "status", "startEnrollAt", "endEnrollAt", "startAt"
        ];

        return $this->activityModel->newQuery()->select($selectFields)->limit(5)
            ->orderByDesc("startEnrollAt")
            ->get()->map(fn($activity) => $activity->append(["activityStatusText"]));
    }

    public function list(array $condition)
    {
        $select = [
            "a_activity.id", "a_activity.title", "a_activity.address", "a_activity.desc", "a_activity.typeID", "a_activity.categoryID", "a_activity.organizerID"
        ];
        //$activityListBuilder = $this->activityModel->newQuery()->select($select)->with(["users"]);
        $activityListBuilder = $this->activityModel->newQuery()->select($select)->with(["organizers"]);

        if (!empty($condition["startTime"])) {
            $activityListBuilder->where("a_activity.startAt", ">=", $condition["startTime"]);
        }

        if (!empty($condition["endTime"])) {
            $activityListBuilder->where("a_activity.endAt", "<=", $condition["endTime"]);
        }
        if (!empty($condition["startEnrollAt"])) {
            $activityListBuilder->where("a_activity.startEnrollAt", ">=", $condition["startEnrollAt"]);
        }
        if (!empty($condition["endEnrollAt"])) {
            $activityListBuilder->where("a_activity.endEnrollAt", "<=", $condition["endEnrollAt"]);
        }

        if (!empty($condition["categoryID"])) {
            $activityListBuilder->where("a_activity.categoryID", "=", $condition["categoryID"]);
        }

        if (!empty($condition["typeID"])) {
            $activityListBuilder->where("a_activity.typeID", "=", $condition["typeID"]);
        }

        if (!empty($condition["organizerID"])) {
            $activityListBuilder->where("a_activity.organizerID", "=", $condition["organizerID"]);
        }

        $activityList = $activityListBuilder->orderByDesc("createdAt")->paginate();
        return $activityList;
    }

    public function myList(string $openId, bool $isEnoll = false)
    {
        $select = ["id", "userName", "userAvatar"];
        $userBuiler = $this->usersModel->newQuery()->where('openId', $openId);
        if ($isEnoll) {
            $userBuiler->select($select)->with(["enollActivity"]);
        } else {
            $userBuiler->select($select)->with(["activity"]);
        }
        return $userBuiler->orderByDesc("createdAt")->get();
    }

}