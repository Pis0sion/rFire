<?php

namespace App\Controller\V1;

use App\Repositories\AdminRepositories;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;


#[Controller(prefix: "/admin/v1")]
class AdminController
{
    protected AdminRepositories $adminRepositories;

    #[RequestMapping(path: "add-admin/{uuid}",methods: "POST")]
    public function addAdmin()
    {

    }

    public function editAdmin()
    {

    }

    public function adminList()
    {

    }

    public function delAdmin()
    {

    }
    public function detail()
    {

    }
}