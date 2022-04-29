<?php

namespace App\Dto;

use App\Model\AdminModel;
use Hyperf\Di\Annotation\Inject;

class AuthorityDto
{
    #[Inject]
    protected AdminModel $adminModel;

    public function getAuthByUserID(int $userID)
    {
        $select = [
            "id","userName","nickName","userAvatar","phone","createdAt","updatedAt"
        ];
        $userModel = $this->adminModel->newQuery()->where('id',$userID);
        $userMenuList = $userModel->select($select)->with(["roles","roles.menus"])->first();
        return $userMenuList;
    }

    public function getRoleByUserID(int $userID)
    {
        $select = [
            "id","userName","nickName","userAvatar","phone","createdAt","updatedAt"
        ];
        $userModel = $this->adminModel->newQuery()->where('id',$userID);
        return $userModel->select($select)->with(["roles"])->first();
    }

    public function isInRoles(int $userID)
    {
        $userModel = $this->adminModel->newQuery()->where('id',$userID)->select(['id','userName'])->first();
        return $userModel->isInRoles($userModel);
    }



}