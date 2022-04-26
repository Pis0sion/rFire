<?php

namespace App\Exception;

/**
 * \App\Exception\UserNotFoundException
 */
class UserNotFoundException extends BaseException
{
    /**
     * @param int $httpCode
     * @param string $errMessage
     * @param int $errCode
     */
    public function __construct(
        public int    $httpCode = 404,
        public string $errMessage = "当前用户不存在或者已被删除...",
        public int    $errCode = 100003
    )
    {
    }
}