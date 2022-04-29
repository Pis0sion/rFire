<?php

namespace App\Repositories;

use App\Dto\AdminDto;
use App\Exception\ParametersException;
use Hyperf\Di\Annotation\Inject;

class AdminRepositories
{
    #[Inject]
    protected AdminDto $adminDto;

    public function login(string $userName,string $password)
    {
        if ($this->adminDto->login($userName,$password)){
            //返回token值
            return '123456';
        }
        throw new ParametersException(errMessage: '用户名或密码错误');
    }

    public function addAdmin(array $data)
    {
        return $this->adminDto->addAdmin($data);
    }

    public function editAdmin(int $id,array $updateData)
    {
        return $this->adminDto->editAdmin($id,$updateData);
    }

    public function delAdmin(int $id)
    {
        return $this->adminDto->delAdmin($id);
    }

    public function listAdmin(array $search)
    {
        return $this->adminDto->listAdmin($search);
    }

    public function detail(int $id)
    {
        return $this->adminDto->detailAdmin($id);
    }

}