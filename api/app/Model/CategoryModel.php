<?php

namespace App\Model;

class CategoryModel extends Model
{
    protected $table = 'a_category';

    protected $fillable = [
        'name'
    ];
    public const CREATED_AT = "createdAt";

    public const UPDATED_AT = "updatedAt";


}