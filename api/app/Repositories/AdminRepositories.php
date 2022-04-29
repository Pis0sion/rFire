<?php

namespace App\Repositories;

use App\Dto\AdminDto;
use Hyperf\Di\Annotation\Inject;

class AdminRepositories
{
    #[Inject]
    protected AdminDto $adminDto;

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