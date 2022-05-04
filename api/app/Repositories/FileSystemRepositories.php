<?php

namespace App\Repositories;

use AlphaSnow\OSS\AppServer\Factory;
use Hyperf\Config\Annotation\Value;

/**
 * \App\Repositories\FileSystemRepositories
 */
class FileSystemRepositories
{

    #[Value("aliyun_oss")]
    protected array $aliyunOssConfigure;

    /**
     * @return array
     */
    public function signature2DirectTransfer()
    {
        $aliyunOssToken = make(Factory::class)->makeToken($this->aliyunOssConfigure);
        return $aliyunOssToken->response();
    }

}