<?php

namespace App\Dto;

use App\Model\ActivityNewsModel;
use Hyperf\Contract\LengthAwarePaginatorInterface;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Dto\ActivityNewsDto
 */
class ActivityNewsDto
{

    #[Inject]
    protected ActivityNewsModel $activityNewsModel;

    /**
     * @return Builder[]|Collection
     */
    public function getActivityHomeNewsList()
    {
        $selectFields = ["id", "title", "categoryID", "cover", "createdAt"];
        return $this->activityNewsModel->newQuery()->limit(5)->orderByDesc("createdAt")->get($selectFields);
    }

    /**
     * @return LengthAwarePaginatorInterface
     */
    public function getActivityNewsList(array $searchParams)
    {
        $selectFields = ["id", "title", "categoryID", "cover", "createdAt"];
        return $this->activityNewsModel->newQuery()->where($searchParams)
            ->with(["category" => fn($query) => $query->select("id", "name")])->select(($selectFields))->orderByDesc("createdAt")->paginate();
    }

    /**
     * @param int $activityNewsID
     * @return Builder|Model|object|null
     */
    public function getActivityNewsDetails(int $activityNewsID)
    {
        return $this->activityNewsModel->newQuery()->where("id", $activityNewsID)->with(
            ["category" => fn($query) => $query->select("id", "name")]
        )->select(["id", "title", "desc", "content", "categoryID", "cover", "createdAt"])->first();
    }

}