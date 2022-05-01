<?php

namespace App\Servlet;

use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;

/**
 * \App\Servlet\AsyncActivityServlet
 */
class AsyncActivityServlet
{
    /**
     * @var DriverInterface
     */
    protected DriverInterface $driverFactory;

    /**
     * @param DriverFactory $driverFactory
     */
    public function __construct(DriverFactory $driverFactory)
    {
        $this->driverFactory = $driverFactory->get("default");
    }

    /**
     * @param $params
     * @param int $delay
     * @return bool
     */
    public function push($params, int $delay = 0): bool
    {
        
    }
}