<?php

namespace App\Model;

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

    public function users()
    {
        return $this->belongsToMany(UsersModel::class);
    }


}