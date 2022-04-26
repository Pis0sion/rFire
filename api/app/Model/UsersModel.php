<?php

namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;

/**
 * \App\Model\UsersModel
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
        "userName", "openID", "userAvatar", "userState","phone","age","cardID","sex"
    ];

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    public const DELETED_AT = "deletedAt";

    public function activity()
    {
        return $this->belongsToMany(ActivityModel::class,'a_registration_list','userID','activityID')->withPivot('score');
    }


}