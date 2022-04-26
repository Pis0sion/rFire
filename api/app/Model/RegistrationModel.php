<?php

namespace App\Model;

class RegistrationModel extends Model
{
    /**
     * @var string
     */
    protected $table = "a_registration_list";

    /**
     * @var string[]
     */
    protected $fillable = [
        "activityID", "userID","score"
    ];
    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";


}