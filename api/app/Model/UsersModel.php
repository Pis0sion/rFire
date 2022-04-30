<?php

namespace App\Model;

use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Database\Model\SoftDeletes;

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
        return $this->belongsToMany(ActivityModel::class, 'a_registration_list', 'userID', 'activityID')
            ->withTimestamps()
            ->withPivot('score');
    }

    /**
     * 我参加的活动
     * @return BelongsToMany
     */
    public function enollActivity()
    {
        return $this->belongsToMany(ActivityModel::class, 'a_registration_list', 'userID', 'activityID')
            ->withTimestamps()
            ->withPivot('score')->wherePivot('isEnoll','=',1);
    }

    /**
     * @param ActivityModel $activityModel
     * @param array $pivotAttributes
     * @return \Hyperf\Database\Model\Model
     */
    public function signUpActivity(ActivityModel $activityModel, array $pivotAttributes = [])
    {
        return $this->activity()->save($activityModel, $pivotAttributes);
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