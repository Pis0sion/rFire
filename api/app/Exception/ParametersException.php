<?php

namespace App\Exception;

/**
 * \App\Exception\ParametersException
 */
class ParametersException extends BaseException
{
    /**
     * @param int $httpCode
     * @param string $errMessage
     * @param int $errCode
     */
    public function __construct(
        public int    $httpCode = 400,
        public string $errMessage = "参数异常，请稍后再试...",
        public int    $errCode = 100001
    )
    {
    }
}