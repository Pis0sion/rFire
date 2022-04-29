<?php

namespace App\Controller\V1;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * \App\Controller\V1\OrganizesController
 */
#[Controller(prefix: "/api/v1")]
class OrganizesController
{

    #[RequestMapping(path: 'organizes-list', methods:'GET')]
    public function getOrganizesList()
    {
        return __FUNCTION__ ;
    }
}