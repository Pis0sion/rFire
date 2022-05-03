<?php

namespace App\Controller\V1;

use App\Repositories\OrganizesRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * \App\Controller\V1\OrganizesController
 */
#[Controller(prefix: "/api/v1")]
class OrganizesController
{
    #[Inject]
    protected OrganizesRepositories $organizesRepositories;

    #[RequestMapping(path: 'organizes-list', methods: 'GET')]
    public function getOrganizesList()
    {
        $organizesList = $this->organizesRepositories->getOrganizerList();
        return renderResponse($organizesList);
    }
}