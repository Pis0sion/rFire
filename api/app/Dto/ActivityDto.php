<?php

namespace App\Dto;

use App\Model\ActivityModel;
use App\Model\UsersModel;
use Carbon\Carbon;
use Hyperf\Contract\LengthAwarePaginatorInterface;
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
            "id", "title", "desc", "cover", "status", "acPerson", "startEnrollAt", "endEnrollAt", "startAt", "endAt"
        ];

        return $this->activityModel->newQuery()->select($selectFields)->limit(5)
            ->where("status", 2)
            ->get()->map(fn($activity) => $activity->append(["activityStatusText"]));
    }

    /**
     * @param array $condition
     * @return LengthAwarePaginatorInterface
     */
    public function activityListByCondition(array $condition)
    {
        $selectFields = [
            "id", "title", "desc", "cover", "status", "startEnrollAt", "endEnrollAt", "startAt", "endAt"
        ];

        $activityListBuilder = $this->activityModel->newQuery()->select($selectFields);

        if ($condition["categoryID"] ?? false) {
            $activityListBuilder->where("a_activity.categoryID", $condition["categoryID"]);
        }

        if ($condition["typeID"] ?? false) {
            $activityListBuilder->where("a_activity.typeID", $condition["typeID"]);
        }

        if ($condition["organizerID"] ?? false) {
            $activityListBuilder->where("a_activity.organizerID", $condition["organizerID"]);
        }

        if ($condition["status"] ?? false) {
            $activityListBuilder->where("a_activity.status", $condition["status"]);
        }

        return $activityListBuilder->orderByDesc("createdAt")->paginate(5);
    }

    /**
     * @param array $activityParameters
     * @return bool
     */
    public function createActivity(array $activityParameters)
    {
        return $this->activityModel->fill($activityParameters)->save();
    }
}