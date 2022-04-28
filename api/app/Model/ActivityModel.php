<?php

namespace App\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\BelongsToMany;
use PhpParser\Node\Stmt\Catch_;

/**
 * \App\Model\ActivityModel
 * @property mixed|void $startEnrollAt
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
        "title", "address", "desc", "typeID", "categoryID", "organizerID", "poster", "startEnrollAt", "endEnrollAt", "startAt", "endAt"
    ];

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    public const DELETED_AT = "deletedAt";


    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(UsersModel::class, "a_registration_list", 'activityID', 'userID')->withPivot("score");
    }

    /**
     * @return int
     */
    public function getActivityStatusTextAttribute()
    {
        return 12;
    }

}