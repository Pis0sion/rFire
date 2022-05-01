<?php

namespace App\Job;

use Hyperf\AsyncQueue\Job;

/**
 * \App\Job\ActivityStateExchangeJob
 */
class ActivityStateExchangeJob extends Job
{

    /**
     * @var mixed
     */
    public mixed $params;

    /**
     * @var int
     */
    protected int $maxAttempts = 2;

    /**
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;
    }


    public function handle()
    {
        var_dump($this->params);
    }
}