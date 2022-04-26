<?php

namespace App\Dto;

use App\Model\ActivityModel;
use Hyperf\Di\Annotation\Inject;

class ActivityDto
{
    #[Inject]
    protected ActivityModel $activityModel;

    public function list(array $condition)
    {
        $select = [
            "a_activity.title","a_activity.address","a_activity.desc","a_activity.typeID","a_activity.categoryID","a_activity.organizerID"
        ];
        $activityListBuilder = $this->activityModel->newQuery()->from("a_activity")->select($select);

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

}