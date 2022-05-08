<?php

namespace App\Job;

use App\Constants\ActivityStatusConstants;
use App\Dto\ActivityDto;
use App\Model\ActivityModel;
use App\Servlet\AsyncActivityServlet;
use Carbon\Carbon;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\HigherOrderTapProxy;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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
    protected $maxAttempts = 2;

    /**
     * @var int
     */
    protected int $deviation = 2;

    /**
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle()
    {

        $activityID = $this->params["activityID"] ?? false;

        $activityStatus = (int)$this->params["activityStatus"] ?? false;

        if (!$activityID || !$activityStatus) {
            return true;
        }

        /**
         * @var ActivityModel $activityDetails
         */
        $activityDetails = $this->getActivityDtoEntity()->getActivityDetails($activityID);

        if (is_null($activityDetails)) {
            return true;
        }

        if ($activityStatus != $activityDetails->getAttribute("status")) {
            return true;
        }

        if ($this->determineActivityStatus($activityDetails, $activityStatus)) {

            $activityDetails->changeNextActivityStatus($activityStatus);

            ++$this->params["activityStatus"];

            if ($this->params["activityStatus"] > ActivityStatusConstants::END_AT) {
                return true;
            }
        }

        $delay = $this->calculateNextProcessDelayTime($activityDetails, $this->params["activityStatus"]);

        $this->getActivityDeliverer()->push($this->params, $delay);
    }

    /**
     * @return ActivityDto|mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getActivityDtoEntity()
    {
        return ApplicationContext::getContainer()->get(ActivityDto::class);
    }

    /**
     * @return AsyncActivityServlet|mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getActivityDeliverer()
    {
        return ApplicationContext::getContainer()->get(AsyncActivityServlet::class);
    }

    /**
     * @param ActivityModel $activityModel
     * @param int $activityStatus
     * @return bool
     */
    protected function determineActivityStatus(ActivityModel $activityModel, int $activityStatus)
    {
        return Carbon::parse($this->getActivityDetailsProcessTime($activityModel, $activityStatus))->addSeconds($this->deviation)->lte(Carbon::now());
    }

    /**
     * @param ActivityModel $activityModel
     * @param int $activityStatus
     * @return int
     */
    protected function calculateNextProcessDelayTime(ActivityModel $activityModel, int $activityStatus): int
    {
        $delay = (int)Carbon::now()->diffInSeconds($this->getActivityDetailsProcessTime($activityModel, $activityStatus), false);

        return max($this->deviation, $delay);
    }

    /**
     * @param ActivityModel $activityModel
     * @param int $activityStatus
     * @return HigherOrderTapProxy|mixed|void
     */
    protected function getActivityDetailsProcessTime(ActivityModel $activityModel, int $activityStatus)
    {
        return $activityModel->getAttribute($this->getActivityProcessStartAtByState($activityStatus));
    }

    /**
     * @param int $state
     * @return string
     */
    protected function getActivityProcessStartAtByState(int $state): string
    {
        return ActivityStatusConstants::getMessage($state);
    }

}