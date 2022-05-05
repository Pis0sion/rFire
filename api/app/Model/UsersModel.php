<?php

namespace App\Model;

use App\Constants\ActivityStatusConstants;
use App\Exception\ParametersException;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Database\Model\SoftDeletes;
use Hyperf\DbConnection\Db;
use MongoDB\BSON\DBPointer;

/**
 * \App\Model\UsersModel
 * @property mixed|void $activity
 */
class UsersModel extends Model
{

    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "a_users";


    /**
     * @var string[]
     */
    protected $fillable = [
        "userName", "openID", "userAvatar", "userState", "phone", "age", "cardID", "sex"
    ];

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    public const DELETED_AT = "deletedAt";

    /**
     * @return BelongsToMany
     */
    public function activity()
    {
        return $this->belongsToMany(ActivityModel::class, "a_registration_list", "userID", "activityID")
            ->withTimestamps()
            ->withPivot('score');
    }

    /**
     * @return Collection
     */
    public function enrollActivity()
    {
        $selectFields = [
            "a_activity.id", "a_activity.title", "a_activity.desc", "a_activity.cover", "a_activity.status",
            "a_activity.startEnrollAt", "a_activity.endEnrollAt", "a_activity.startAt", "a_activity.endAt"
        ];

        return $this->activity()->select($selectFields)->get()->makeHidden(["pivot"]);
    }

    /**
     * @return Collection
     */
    public function pendingActivity()
    {
        $selectFields = [
            "a_activity.id", "a_activity.title", "a_activity.desc", "a_activity.cover", "a_activity.status",
            "a_activity.startEnrollAt", "a_activity.endEnrollAt", "a_activity.startAt", "a_activity.endAt"
        ];

        return $this->activity()->wherePivot("isActivity", "=", 0)
            ->where("status", ActivityStatusConstants::END_AT)
            ->select($selectFields)->get();
    }

    /**
     * @return Collection
     */
    public function participateActivity()
    {
        $selectFields = [
            "a_activity.id", "a_activity.title", "a_activity.desc", "a_activity.cover", "a_activity.status",
            "a_activity.startEnrollAt", "a_activity.endEnrollAt", "a_activity.startAt", "a_activity.endAt"
        ];

        return $this->activity()->select($selectFields)->wherePivot("isActivity", "=", 1)->get();
    }

    /**
     * @param ActivityModel $activityModel
     * @param array $pivotAttributes
     * @return bool
     * @throws ParametersException
     */
    public function signUpActivity(ActivityModel $activityModel, array $pivotAttributes = [])
    {
        Db::beginTransaction();

        try {
            $this->activity()->save($activityModel, $pivotAttributes);
            $activityModel->increment("esPerson");
            Db::commit();

            return true;
        } catch (\Throwable $throwable) {
            Db::rollBack();
            throw new ParametersException(errMessage: "报名失败，请稍后再试...");
        }
    }

    /**
     * @param ActivityModel $activityModel
     * @return bool
     */
    public function whetherUserParticipatesInActivity(ActivityModel $activityModel)
    {
        return $this->activity->contains($activityModel);
    }

}