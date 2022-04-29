<?php

namespace App\Model;

use Hyperf\Utils\Collection;

/**
 * \App\Model\AdminModel
 */
class AdminModel extends Model
{
    /**
     * @var string
     */
    protected $table = "a_admin";

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    protected $fillable = [
        "userName", "password", "nickName", "userAvatar", "phone"
    ];

    /**
     * 用户有哪些角色
     * @return \Hyperf\Database\Model\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'a_admin_role', 'adminID', 'roleID');
    }

    /**
     * 给用户添加角色
     * @param RoleModel $roleModel
     * @return \Hyperf\Database\Model\Model
     */
    public function assignRole(RoleModel $roleModel)
    {
        return $this->roles()->save($roleModel);
    }


    /**
     * 取消用户角色
     * @param $role
     * @return int
     */
    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }

    /**
     * 用户是否有某个角色
     * @param $role
     * @return bool
     */
    public function isInRoles($role)
    {

        return !!$role->intersect($this->roles)->count();
    }

    /**
     * 用户是否拥有某个权限
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->isInRoles($permission->roles);

    }



}