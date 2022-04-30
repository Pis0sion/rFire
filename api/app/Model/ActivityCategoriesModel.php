<?php

namespace App\Model;

use Hyperf\Database\Model\Relations\HasMany;

/**
 * \App\Model\ActivityCategoriesModel
 */
class ActivityCategoriesModel extends Model
{
    /**
     * @var string
     */
    protected $table = "a_category";

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    /**
     * @return HasMany
     */
    public function activity()
    {
        return $this->hasMany(ActivityModel::class, "CategoryID", "id");
    }
}