<?php

namespace App\Exception;

/**
 * \App\Exception\SuccessfulException
 */
class SuccessfulException extends BaseException
{
    /**
     * @param int $httpCode
     * @param string $errMessage
     * @param int $errCode
     */
    public function __construct(
        public int    $httpCode = 200,
        public string $errMessage = "操作成功",
        public int    $errCode = 100000
    )
    {
    }
}