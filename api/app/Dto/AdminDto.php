<?php

namespace App\Dto;

use App\Exception\ParametersException;
use App\Model\AdminModel;
use Hyperf\Di\Annotation\Inject;

class AdminDto
{
    #[Inject]
    protected AdminModel $adminModel;

    public function addAdmin(array $data)
    {
        return $this->adminModel->newQuery()->create();
    }

    public function editAdmin(int $id,array $updateData)
    {
        return $this->adminModel->newQuery()->where("id",$id)->update($updateData);
    }

    public function delAdmin(int $id)
    {
        return $this->adminModel->newQuery()->delete($id);
    }

    public function detailAdmin(int $id)
    {
        return $this->adminModel->newQuery()->find($id);
    }

    public function listAdmin(array $search)
    {
        $adminBuilder = $this->adminModel->newQuery()->where([$search])->select(["*"]);
        $adminList = $adminBuilder->orderBy("createdAt","desc")->paginate();
        return $adminList;
    }

    public function login(array $userData)
    {
        $userModel = $this->adminModel->newQuery()->where("userName",$userData["userName"])->first();
        if (!is_null($userModel)){
            if ($userModel->password == $userData['password']){
                return true;
            }
        }
        throw new ParametersException(errMessage: "用户名或密码错误");
    }
}