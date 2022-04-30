<?php

namespace App\Controller\V1;

use App\Repositories\BannerRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller(prefix: '/api/v1')]
class IndexController
{
    #[Inject]
    protected BannerRepositories $bannerRepositories;

    #[RequestMapping(path: 'index-banner-list', methods:'GET')]
    public function list(RequestInterface $request)
    {
        $limit = $request->input('limit',3);
        return renderResponse($this->bannerRepositories->listBanner($limit));
    }

}