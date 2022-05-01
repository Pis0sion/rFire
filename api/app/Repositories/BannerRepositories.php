<?php

namespace App\Repositories;

use App\Dto\BannerDto;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Di\Annotation\Inject;

class BannerRepositories
{
    #[Inject]
    protected BannerDto $bannerDto;

    /**
     * @param int $limit
     * @return Builder[]|Collection
     */
    public function listBanner(int $limit)
    {
        return $this->bannerDto->listBanner($limit);
    }
}