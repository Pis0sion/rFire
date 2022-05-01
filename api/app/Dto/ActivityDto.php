<?php

namespace App\Dto;

use App\Model\ActivityModel;
use App\Model\UsersModel;
use Carbon\Carbon;
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
     * @param int $activityID
     * @return Builder|Model|object|null
     */
    public function getActivityDetailsWithOrganizersAndCategories(int $activityID)
    {
        return $this->activityModel->newQuery()->with([
            "organizers" => fn($query) => $query->select(["id", "name"]),
            "categories" => fn($query) => $query->select(["id", "name"])
        ])->where("id", $activityID)->first();
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
            ->where("startEnrollAt", "<=", Carbon::now())
            ->where("endEnrollAt", ">=", Carbon::now())
            ->get()->map(fn($activity) => $activity->append(["activityStatusText"]));
    }

    public function list(array $condition)
    {
        $select = [
            "a_activity.id", "a_activity.title", "a_activity.address", "a_activity.desc", "a_activity.typeID", "a_activity.categoryID", "a_activity.organizerID"
        ];

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

        return $activityListBuilder->orderByDesc("createdAt")->paginate();
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