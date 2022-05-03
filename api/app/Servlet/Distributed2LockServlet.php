<?php

namespace App\Servlet;

use App\Exception\TimeOutException;
use Hyperf\Redis\Redis;
use Hyperf\Redis\RedisFactory;
use Lysice\HyperfRedisLock\LockTimeoutException;
use Lysice\HyperfRedisLock\RedisLock;

/**
 * \App\Servlet\Distributed2LockServlet
 */
class Distributed2LockServlet
{
    /**
     * @var Redis
     */
    protected Redis $redisInstance;

    /**
     * @param RedisFactory $redisFactory
     */
    public function __construct(RedisFactory $redisFactory)
    {
        $this->redisInstance = $redisFactory->get("default");
    }

    /**
     * @throws TimeOutException
     */
    public function distributed2Lock(string $lockName, callable $callable)
    {
        try {
            $lock = new RedisLock($this->redisInstance, $lockName, 5);
            return $lock->block(5, $callable);
        } catch (LockTimeoutException $lockTimeoutException) {
            throw new TimeOutException();
        }
    }

}