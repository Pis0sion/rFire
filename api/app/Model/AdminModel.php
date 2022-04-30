<?php

namespace App\Model;

use Hyperf\Database\Model\Collection;

/**
 * \App\Model\AdminModel
 * @property mixed|void $roles
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
        "userName", "password", "nickName", "userAvatar", "phonephone"
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
     * 用户是否有某个角色(某些角色)
     * @param Collection $roles
     * @return bool
     */
    public function isInRoles(Collection $roles)
    {
        return !!$roles->intersect($this->roles)->count();
    }

    /**
     * 用户是否有某个权限
     * @param MenuModel $permission
     * @return bool
     */
    public function hasPermission(MenuModel $permission)
    {
        return $this->isInRoles($permission->roles);
    }

    /**
     * 给用户分配角色
     * @param RoleModel $role
     * @return \Hyperf\Database\Model\Model
     */
    public function assignRole(RoleModel $role)
    {
        return $this->roles()->save($role);
    }

    /**
     * 取消用户的角色
     * @param $role
     * @return int
     */
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }


}