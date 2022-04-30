<?php

namespace App\Model;

class RoleModel extends Model
{
    /**
     * @var string
     */
    protected $table = "a_role";

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    public const DELETED_AT = 'deletedAt';

    protected $fillable = [
        "roleName", "desc"
    ];


    /**
     * 当前角色的所有权限
     * @return \Hyperf\Database\Model\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(MenuModel::class,'a_role_menu','roleID','MenuID');
    }

    /**
     * 给角色分配权限
     * @param $permission
     * @return \Hyperf\Database\Model\Model
     */
    public function addPermissions($permission)
    {
        return $this->permissions()->save($permission);
    }

    /**
     * 取消角色的权限
     * @param $permission
     * @return int
     */
    public function deletePermissions($permission)
    {
        return $this->permissions()->detach($permission);
    }

    /**
     * 判断角色是否有权限
     * @param $permission
     * @return mixed
     */
    public function hasPermissions($permission)
    {
        return $this->permissions->contains($permission);
    }



}