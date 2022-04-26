<?php

namespace App\Exception;

/**
 * \App\Exception\BaseException
 */
class BaseException extends \Exception
{

    /**
     * @param int $httpCode
     * @param string $errMessage
     * @param int $errCode
     */
    public function __construct(
        public int    $httpCode = 400,
        public string $errMessage = "invalid parameter",
        public int    $errCode = 100001
    )
    {
    }
}