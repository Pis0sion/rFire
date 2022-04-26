<?php

namespace App\Repositories;

use App\Dto\UsersDto;
use App\Exception\ParametersException;
use Hyperf\Di\Annotation\Inject;

class UserRepositories
{
     #[Inject]
     protected UsersDto $usersDto;

     public function createUser(string $openId,array $data)
     {
         return $this->usersDto->createOrFindUserByOpenID($openId,$data);
     }

     public function getUserInfo(string $openId)
     {
         $userInfo = $this->usersDto->getUserInfo($openId);
         if (is_null($userInfo)){
             throw  new ParametersException(errMessage: "用户不存在");
         }
         return $userInfo;
     }

     public function bindUserInfo(string $openId,array $userData)
     {
        return $this->usersDto->bindUserInfo($openId,$userData);
     }


}