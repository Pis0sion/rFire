<?php

namespace App\Model;

class RoleMenuModel extends Model
{
    /**
     * @var string
     */
    protected $table = "a_role_menu";

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    public const DELETED_AT = 'deletedAt';

    protected $fillable = [
        "roleID", "menuID"
    ];

}