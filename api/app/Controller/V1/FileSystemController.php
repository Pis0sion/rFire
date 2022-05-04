<?php

namespace App\Controller\V1;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * \App\Controller\V1\FileSystemController
 */
#[Controller(prefix: "/api/v1")]
class FileSystemController
{


    #[RequestMapping(path: "sign/url", methods: "POST")]
    public function test()
    {
        return __FUNCTION__;
    }
}