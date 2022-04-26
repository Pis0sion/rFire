<?php

namespace App\Model;

class AdminModel extends Model
{
    /**
     * @var string
     */
    protected $table = "a_admin";

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    protected $fillable = [
        "userName", "password", "nickName","userAvatar","phonephone"
    ];

}