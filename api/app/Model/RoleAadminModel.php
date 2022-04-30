<?php

namespace App\Model;

class RoleAadminModel extends Model
{
    /**
     * @var string
     */
    protected $table = "a_admin_role";

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    public const DELETED_AT = 'deletedAt';

    protected $fillable = [
        "adminID", "roleID"
    ];
}