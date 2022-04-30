<?php

namespace App\Repositories;

use App\Dto\AuthorityDto;
use Hyperf\Di\Annotation\Inject;

class AuthorityRepositories
{
    #[Inject]
    protected AuthorityDto $authorityDto;

    public function getRoleByUserID(int $userID)
    {
        return $this->authorityDto->getRoleByUserID($userID);
    }

    public function isInRoles(int $userID)
    {
        return $this->authorityDto->isInRoles($userID);
    }


}