<?php

namespace App\Dto;

use App\Exception\ParametersException;
use App\Model\AdminModel;
use Hyperf\Di\Annotation\Inject;

class AdminDto
{
    #[Inject]
    protected AdminModel $adminModel;

    public function login(string $userName, string $password)
    {
       $adminModel = $this->adminModel->newQuery()->where('userName',$userName)->first();
       if (password_verify($password,$adminModel->password)){
          return true;
       }
       return false;
    }

    public function addAdmin(array $data)
    {
        return $this->adminModel->newQuery()->create();
    }

    public function editAdmin(int $id,array $updateData)
    {
        return $this->adminModel->newQuery()->where("id",$id)->update($updateData);
    }

    public function delAdmin($id)
    {
        return $this->adminModel->newQuery()->delete($id);
    }

    public function detailAdmin($id)
    {
        return $this->adminModel->newQuery()->find($id);
    }

    public function listAdmin($search)
    {
        $adminBuilder = $this->adminModel->newQuery()->where([$search])->select(["*"]);
        $adminList = $adminBuilder->orderBy("createdAt","desc")->paginate();
        return $adminList;
    }
}