<?php

namespace App\Dto;

use App\Model\BannerModel;
use Hyperf\Di\Annotation\Inject;

class BannerDto
{
    #[Inject]
    protected BannerModel $bannerModel;

    public function addBanner(array $data)
    {

    }

    public function listBanner(int $limit)
    {
        return $this->bannerModel->newQuery()->limit($limit)->orderBy("createdAt","desc")->get();
    }





}