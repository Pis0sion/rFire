<?php

namespace App\Model;

/**
 * \App\Model\ActivityModel
 */
class ActivityModel extends Model
{
    /**
     * @var string
     */
    protected $table = "a_activity";

    /**
     * @var string[]
     */
    protected $fillable = [
        "title", "address", "desc", "typeID","categoryID","organizerID","poster","startAt","endAt"
    ];

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    public const DELETED_AT = "deletedAt";

    /**
     * @return \Hyperf\Database\Model\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(UsersModel::class,"a_registration_list",'activityID','userID')->withPivot("score");
    }


}