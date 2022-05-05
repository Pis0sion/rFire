<?php

namespace App\Model;

/**
 * \App\Model\CategoryModel
 */
class CategoryModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'a_category';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name'
    ];

    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";


}