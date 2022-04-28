<?php

namespace App\Dto;

use App\Model\ActivityModel;

use App\Model\UsersModel;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
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
     * @return Builder[]|Collection
     */
    public function activityLatestByList()
    {
        $selectFields = [
            "id", "title", "desc", "status", "startEnrollAt", "endEnrollAt", "startAt"
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
        $activityListBuilder = $this->activityModel->newQuery()->select($select)->with(["users"]);

        if (!empty($condition['startTime'])) {
            $activityListBuilder->where("a_activity.startAt", ">=", $condition["startTime"]);
        }

        if (!empty($condition["endTime"])) {
            $activityListBuilder->where("a_activity.endAt", "<=", $condition["endTime"]);
        }

        if (!empty($condition["category"])) {
            $activityListBuilder->where("a_activity.categoryID", "=", $condition["category"]);
        }
        $activityList = $activityListBuilder->orderByDesc("createdAt")->paginate();
        return $activityList;
    }

    public function myList(string $openId)
    {
        $userBuiler = $this->usersModel->newQuery()->where('openId', $openId);
        return $userBuiler->select(['*'])->with(["activity"])->orderByDesc("createdAt")->paginate();
    }

}