<?php

namespace App\Repositories;

use App\Dto\OrganizesDto;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Repositories\OrganizesRepositories
 */
class OrganizesRepositories
{

    #[Inject]
    protected OrganizesDto $organizesDto;

    /**
     * @return Builder[]|Collection
     */
    public function getOrganizerList()
    {
        return $this->organizesDto->getOrganizerList();
    }
}