<?php

namespace App\Repositories;

use App\Dto\BannerDto;
use Hyperf\Di\Annotation\Inject;

class BannerRepositories
{
    #[Inject]
    protected BannerDto $bannerDto;

    public function listBanner(int $limit)
    {
        return $this->bannerDto->listBanner($limit);
    }
}