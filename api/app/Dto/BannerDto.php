<?php

namespace App\Dto;

use App\Model\BannerModel;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Dto\BannerDto
 */
class BannerDto
{
    #[Inject]
    protected BannerModel $bannerModel;

    public function addBanner(array $data)
    {

    }

    /**
     * @param int $limit
     * @return Builder[]|Collection
     */
    public function listBanner(int $limit)
    {
        return $this->bannerModel->newQuery()->limit($limit)
            ->orderByDesc("sort")
            ->orderByDesc("createdAt")
            ->get();
    }


}