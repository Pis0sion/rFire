<?php

namespace App\Repositories;

use App\Dto\ActivityNewsDto;
use App\Exception\ParametersException;
use Hyperf\Contract\LengthAwarePaginatorInterface;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Repositories\ActivityNewsRepositories
 */
class ActivityNewsRepositories
{
    #[Inject]
    protected ActivityNewsDto $activityNewsDto;

    /**
     * @return Builder[]|Collection
     */
    public function getActivityHomeNewsList()
    {
        return $this->activityNewsDto->getActivityHomeNewsList();
    }

    /**
     * @return LengthAwarePaginatorInterface
     */
    public function getActivityNewsList(array $searchParams)
    {
        return $this->activityNewsDto->getActivityNewsList($searchParams);
    }

    /**
     * @param int $activityNewsID
     * @return Builder|Model|object|null
     * @throws ParametersException
     */
    public function getActivityNewsDetails(int $activityNewsID)
    {
        $activityNews = $this->activityNewsDto->getActivityNewsDetails($activityNewsID);

        if (is_null($activityNews)) {
            throw new ParametersException();
        }

        return $activityNews;
    }
}