<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\Contract\LengthAwarePaginatorInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

if (!function_exists("response")) {

    function response()
    {
        return make(ResponseInterface::class);
    }
}


if (!function_exists("renderResponse")) {

    function renderResponse(mixed $responseData = null)
    {
        $unifiedResponse = [
            "errCode" => 100000,
            "errMessage" => "操作成功",
            "responseData" => $responseData,
        ];

        return response()->json(array_filter($unifiedResponse));
    }
}


if (!function_exists("paginate")) {

    function paginate(LengthAwarePaginatorInterface $PaginateList): array
    {
        return ["listItem" => $PaginateList->items(), "pageItem" => [
            "totalCount" => $PaginateList->total(),
            "currentPage" => $PaginateList->currentPage(),
            "perPage" => $PaginateList->perPage(),]
        ];
    }
}

if (!function_exists("real2Ip")) {
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function real2Ip()
    {
        $request = ApplicationContext::getContainer()->get(RequestInterface::class);
        $headers = $request->getHeaders();

        if (isset($headers['x-forwarded-for'][0]) && !empty($headers['x-forwarded-for'][0])) {
            return $headers['x-forwarded-for'][0];
        } elseif (isset($headers['x-real-ip'][0]) && !empty($headers['x-real-ip'][0])) {
            return $headers['x-real-ip'][0];
        }

        $serverParams = $request->getServerParams();
        return $serverParams['remote_addr'] ?? '';
    }
}