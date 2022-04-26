<?php

namespace App\Exception\Handler;

use App\Exception\BaseException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * \App\Exception\Handler\CustomAdminExceptionHandler
 */
class CustomAdminExceptionHandler extends ExceptionHandler
{

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        /**
         * @var BaseException $throwable
         */
        return $response->withHeader("content-type", "application/json")
            ->withStatus($throwable->httpCode)
            ->withBody(new SwooleStream(json_encode([
                "errCode" => $throwable->errCode,
                "errMessage" => $throwable->errMessage,
            ])));
    }

    /**
     *
     * @param Throwable $throwable
     * @return bool
     */
    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof BaseException;
    }
}