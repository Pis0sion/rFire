<?php

namespace App\Model;

/**
 * @property mixed|void $roles
 */
class MenuModel extends Model
{
    /**
     * @var string
     */
    protected $table = "a_menu";

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    public const DELETED_AT = 'deletedAt';

    protected $fillable = [
        "name", "parentID","path_url"
    ];

    /**
     * 当前权限属于哪个角色
     * @return \Hyperf\Database\Model\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class,'a_role_menu','menuID','roleID');
    }

}