<?php

namespace App\Exception;

/**
 * \App\Exception\TimeOutException
 */
class TimeOutException extends BaseException
{
    /**
     * @param int $httpCode
     * @param string $errMessage
     * @param int $errCode
     */
    public function __construct(
        public int    $httpCode = 408,
        public string $errMessage = "请求超时，请稍后再试",
        public int    $errCode = 100008
    )
    {
    }
}