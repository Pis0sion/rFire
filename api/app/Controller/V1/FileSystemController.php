<?php

namespace App\Controller\V1;

use App\Repositories\FileSystemRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * \App\Controller\V1\FileSystemController
 */
#[Controller(prefix: "/api/v1")]
class FileSystemController
{
    #[Inject]
    protected FileSystemRepositories $fileSystemRepositories;

    #[RequestMapping(path: "sign/url", methods: "POST")]
    public function directTransferBySignUrl()
    {
        $signature = $this->fileSystemRepositories->signature2DirectTransfer();

        return renderResponse($signature);
    }

    #[RequestMapping(path: "oss/callback", methods: "POST")]
    public function directTransferByCallback(RequestInterface $request)
    {
        var_dump($request->all());
    }
}