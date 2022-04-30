<?php

namespace App\Dto;

use App\Model\OrganizerModel;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Dto\OrganizesDto
 */
class OrganizesDto
{
    /**
     * @var OrganizerModel
     */
    #[Inject]
    protected OrganizerModel $organizerModel;

    /**
     * @return Builder[]|Collection
     */
    public function getOrganizerList()
    {
        return $this->organizerModel->newQuery()->orderByDesc("createdAt")->get();
    }


}