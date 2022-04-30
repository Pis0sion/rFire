<?php

namespace App\Model;

use Hyperf\Database\Model\Relations\HasMany;
use Hyperf\Database\Model\SoftDeletes;

/**
 * \App\Model\OrganizerModel
 */
class OrganizerModel extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "a_organizer";

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    public const DELETED_AT = "deletedAt";

    /**
     * @var string[]
     */
    protected $fillable = [
        "name", "desc", "logo", "grade"
    ];

    /**
     * @return HasMany
     */
    public function activity()
    {
        return $this->hasMany(ActivityModel::class, "organizerID", "id");
    }
}