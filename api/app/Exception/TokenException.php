<?php

namespace App\Exception;

/**
 * \App\Exception\TokenException
 */
class TokenException extends BaseException
{
    /**
     * @param int $httpCode
     * @param string $errMessage
     * @param int $errCode
     */
    public function __construct(
        public int    $httpCode = 401,
        public string $errMessage = "token 无效或者已过期...",
        public int    $errCode = 100005
    )
    {
    }
}