<?php

namespace App\Controller\V1;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * \App\Controller\V1\HomeController
 */
#[Controller(prefix: "/admin/v1")]
class HomeController
{

    #[RequestMapping(path: "index", methods: "GET")]
    public function index()
    {
        return __FUNCTION__;
    }




}