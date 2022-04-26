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
        "userName", "openID", "userAvatar", "userState",
    ];


}