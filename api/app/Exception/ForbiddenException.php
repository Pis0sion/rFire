<?php

namespace App\Exception;

/**
 * \App\Exception\ForbiddenException
 */
class ForbiddenException extends BaseException
{
    /**
     * @param int $httpCode
     * @param string $errMessage
     * @param int $errCode
     */
    public function __construct(
        public int    $httpCode = 401,
        public string $errMessage = "参数异常，请稍后再试...",
        public int    $errCode = 100004
    )
    {
    }
}