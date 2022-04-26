<?php

namespace App\Repositories;

use App\Dto\ActivityDto;
use Hyperf\Di\Annotation\Inject;

class ActivityRepositories
{
    #[Inject]
    protected ActivityDto $activityDto;

    public function list(array $search)
    {
        return $this->activityDto->list($search);
    }
    public function myList(string $uuid)
    {

    }

}