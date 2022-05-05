<?php

namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;

/**
 * \App\Model\ActivityNewsCategoryModel
 */
class ActivityNewsCategoryModel extends Model
{

    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "a_news_category";

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";

    public const DELETED_AT = "deletedAt";
}