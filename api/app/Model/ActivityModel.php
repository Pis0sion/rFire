<?php

namespace App\Model;

use App\Constants\ActivityStatusConstants;
use App\Servlet\AsyncActivityServlet;
use Carbon\Carbon;
use Hyperf\Database\Model\Events\Saved;
use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Database\Model\Relations\BelongsToMany;
use Hyperf\Database\Model\Relations\HasMany;
use Hyperf\Di\Annotation\Inject;

/**
 * \App\Model\ActivityModel
 * @property mixed|void $startEnrollAt
 * @property mixed|void $endEnrollAt
 * @property mixed|void $startAt
 * @property mixed|void $endAt
 */
class ActivityModel extends Model
{
    #[Inject]
    protected AsyncActivityServlet $asyncActivityServlet;

    /**
     * @var string
     */
    protected $table = "a_activity";

    /**
     * @var string[]
     */
    protected $fillable = [
        "title", "address", "content", "typeID", "categoryID", "organizerID", "poster", "startEnrollAt", "endEnrollAt", "startAt", "endAt"
    ];

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    public const DELETED_AT = "deletedAt";

    protected $casts = [
        "status" => "integer",
    ];

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(UsersModel::class, "a_registration_list", 'activityID', 'userID')->withPivot("score");
    }

    /**
     * @return BelongsTo
     */
    public function organizers()
    {
        return $this->belongsTo(OrganizerModel::class, "organizerID", "id");
    }

    /**
     * @return BelongsTo
     */
    public function categories()
    {
        return $this->belongsTo(ActivityCategoriesModel::class, "categoryID", "id");
    }

    public function types()
    {
        return $this->belongsTo(TypeModel::class, "typeID", "id");
    }

    /**
     * @return string
     */
    public function getActivityStatusTextAttribute(): string
    {
        $activityStatusText = "活动待开启报名";

        if (Carbon::parse(Carbon::now())->gt($this->startEnrollAt) &&
            Carbon::parse(Carbon::now())->lte($this->endEnrollAt)
        ) {
            $activityStatusText = "立即报名";
        }

        if (Carbon::parse(Carbon::now())->gt($this->endEnrollAt) &&
            Carbon::parse(Carbon::now())->lte($this->startAt)
        ) {
            $activityStatusText = "报名已截至，活动即将开始";
        }

        if (Carbon::parse(Carbon::now())->gt($this->startAt) &&
            Carbon::parse(Carbon::now())->lte($this->endAt)
        ) {
            $activityStatusText = "活动进行中";
        }

        if (Carbon::parse(Carbon::now())->gt($this->endAt)) {
            $activityStatusText = "活动已结束";
        }
        return $activityStatusText;
    }

    /**
     * @return string
     */
    public function getRedirectApiAttribute(): string
    {
        return "";
    }

    /**
     * @param int $activityStatus
     * @return int
     */
    public function changeNextActivityStatus(int $activityStatus)
    {
        if ($this->getAttribute("status") == $activityStatus) {

            return $this->increment("status", 1);
        }

        return 0;
    }

    /**
     * @return HasMany
     */
    public function clockPoints()
    {
        return $this->hasMany(ClockPointsModel::class, "activityID", "id");
    }

    /**
     * @param int $activityStatus
     * @return int
     */
    public function incrementAcPersonCount()
    {
        if ($this->getAttribute("status") == ActivityStatusConstants::END_AT) {

            return $this->increment("acPerson");
        }

        return 0;
    }

}