<?php

namespace App\Dto;

use App\Model\UsersModel;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Dto\UsersDto
 */
class UsersDto
{

    #[Inject]
    protected UsersModel $usersModel;

    /**
     * @param string $openID
     * @param array $users
     * @return Builder|Model
     */
    public function createOrFindUserByOpenID(string $openID, array $users)
    {
        return $this->usersModel->newQuery()->firstOrCreate(["openID" => $openID], $users);
    }

}