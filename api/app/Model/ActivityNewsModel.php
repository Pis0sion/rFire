<?php

namespace App\Model;

use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Database\Model\SoftDeletes;

/**
 * \App\Model\ActivityNewsModel
 */
class ActivityNewsModel extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "a_news";

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    public const DELETED_AT = "deletedAt";

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ActivityNewsCategoryModel::class, "categoryID", "id");
    }
}