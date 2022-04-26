<?php

namespace App\Exception;

/**
 * \App\Exception\SendFrequentlyException
 */
class SendFrequentlyException extends BaseException
{
    /**
     * @param int $httpCode
     * @param string $errMessage
     * @param int $errCode
     */
    public function __construct(
        public int    $httpCode = 429,
        public string $errMessage = "频繁发送，请稍后再试...",
        public int    $errCode = 100002
    )
    {
    }
}