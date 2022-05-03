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

    /**
     * @param string $openId
     * @return Builder|Model|object|null
     */
    public function getUserInfo(string $openId)
    {
        return $this->usersModel->newQuery()->where("openID",$openId)->first();
    }

    /**
     * @param string $openId
     * @param array $userData
     * @return int
     */
    public function bindUserInfo(string $openId,array $userData)
    {
       return $this->usersModel->newQuery()->where("openID",$openId)->update($userData);
    }
}