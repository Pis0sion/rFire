<?php

namespace App\Controller\V1;

use App\Repositories\AuthorityRepositories;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

#[Controller(prefix: '/api/v1')]
class AuthorityController
{
    #[Inject]
    protected AuthorityRepositories $authorityRepositories;



}